<?php
namespace Vira\Modules\Tiered_Pricing;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( '18-tiered-pricing' ) ) {
			return;
		}
		add_action( 'add_meta_boxes', array( __CLASS__, 'box' ) );
		add_action( 'save_post_product', array( __CLASS__, 'save' ) );
		add_filter( 'woocommerce_product_get_price', array( __CLASS__, 'price' ), 20, 2 );
		add_filter( 'woocommerce_product_variation_get_price', array( __CLASS__, 'price' ), 20, 2 );
	}

	public static function box() {
		add_meta_box( 'vira_b2b', 'قیمت پلکانی B2B', array( __CLASS__, 'render_box' ), 'product', 'normal' );
	}

	public static function render_box( $post ) {
		wp_nonce_field( 'vira_b2b', 'vira_b2b_nonce' );
		$rows = get_post_meta( $post->ID, '_vira_b2b_tiers', true );
		if ( ! is_array( $rows ) ) {
			$rows = array(
				array( 'min' => 1, 'max' => 4, 'type' => 'percent', 'value' => 0 ),
				array( 'min' => 5, 'max' => 9, 'type' => 'percent', 'value' => 5 ),
				array( 'min' => 10, 'max' => 49, 'type' => 'percent', 'value' => 10 ),
				array( 'min' => 50, 'max' => 0, 'type' => 'percent', 'value' => 15 ),
			);
		}
		echo '<p>min / max / percent</p>';
		foreach ( $rows as $i => $r ) {
			echo '<p>';
			echo '<input name="vira_b2b[' . esc_attr( $i ) . '][min]" type="number" value="' . esc_attr( $r['min'] ) . '" style="width:80px">';
			echo '<input name="vira_b2b[' . esc_attr( $i ) . '][max]" type="number" value="' . esc_attr( $r['max'] ) . '" style="width:80px">';
			echo '<input name="vira_b2b[' . esc_attr( $i ) . '][value]" type="number" value="' . esc_attr( $r['value'] ) . '" style="width:80px"> %';
			echo '</p>';
		}
	}

	public static function save( $post_id ) {
		if ( ! isset( $_POST['vira_b2b_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vira_b2b_nonce'] ) ), 'vira_b2b' ) ) {
			return;
		}
		if ( empty( $_POST['vira_b2b'] ) || ! is_array( $_POST['vira_b2b'] ) ) {
			return;
		}
		$out = array();
		foreach ( $_POST['vira_b2b'] as $row ) {
			$out[] = array(
				'min'   => absint( $row['min'] ),
				'max'   => absint( $row['max'] ),
				'type'  => 'percent',
				'value' => absint( $row['value'] ),
			);
		}
		update_post_meta( $post_id, '_vira_b2b_tiers', $out );
	}

	public static function price( $price, $product ) {
		if ( is_admin() && ! wp_doing_ajax() ) {
			return $price;
		}
		if ( ! $product || $price === '' ) {
			return $price;
		}
		$qty = 1;
		if ( function_exists( 'WC' ) && WC()->cart ) {
			foreach ( WC()->cart->get_cart() as $item ) {
				if ( (int) $item['product_id'] === (int) $product->get_id() ) {
					$qty = (int) $item['quantity'];
				}
			}
		}
		$tiers = get_post_meta( $product->get_id(), '_vira_b2b_tiers', true );
		if ( ! is_array( $tiers ) ) {
			return $price;
		}
		foreach ( $tiers as $t ) {
			$min = (int) $t['min'];
			$max = (int) $t['max'];
			if ( $qty >= $min && ( 0 === $max || $qty <= $max ) ) {
				$pct = (int) $t['value'];
				if ( $pct > 0 && $pct < 100 ) {
					return (float) $price * ( 1 - ( $pct / 100 ) );
				}
			}
		}
		return $price;
	}
}
