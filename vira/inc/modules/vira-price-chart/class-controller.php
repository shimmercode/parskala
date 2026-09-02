<?php
namespace Vira\Modules\Price_Chart;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'save_post_product', array( __CLASS__, 'track_price' ), 20, 2 );
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'chart' ), 28 );
	}

	public static function track_price( $post_id, $post ) {
		if ( wp_is_post_revision( $post_id ) || ! function_exists( 'wc_get_product' ) ) {
			return;
		}
		$p = wc_get_product( $post_id );
		if ( ! $p ) {
			return;
		}
		$hist = get_post_meta( $post_id, '_vira_price_history', true );
		if ( ! is_array( $hist ) ) {
			$hist = array();
		}
		$now = (float) $p->get_price();
		$last = $hist ? (float) end( $hist )['price'] : null;
		if ( $last !== $now ) {
			$hist[] = array( 'date' => wp_date( 'Y/m/d' ), 'price' => $now );
			update_post_meta( $post_id, '_vira_price_history', array_slice( $hist, -30 ) );
		}
	}

	public static function chart() {
		global $product;
		if ( ! $product ) {
			return;
		}
		self::track_price( $product->get_id(), null );
		$hist = get_post_meta( $product->get_id(), '_vira_price_history', true );
		if ( ! is_array( $hist ) || count( $hist ) < 1 ) {
			return;
		}
		$max = 1;
		foreach ( $hist as $h ) {
			$max = max( $max, (float) $h['price'] );
		}
		echo '<div class="vira-price-chart"><h4>نمودار قیمت</h4><div class="vira-bars">';
		foreach ( $hist as $h ) {
			$hgt = max( 8, ( (float) $h['price'] / $max ) * 80 );
			echo '<div class="vira-bar" title="' . esc_attr( $h['date'] . ' — ' . $h['price'] ) . '"><i style="height:' . esc_attr( $hgt ) . 'px"></i></div>';
		}
		echo '</div></div>';
	}
}
