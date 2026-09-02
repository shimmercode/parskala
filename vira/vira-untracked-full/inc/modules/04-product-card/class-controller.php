<?php
/**
 * Next-gen product card badges.
 *
 * @package Vira
 */

namespace Vira\Modules\Product_Card;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'woocommerce_before_shop_loop_item_title', array( __CLASS__, 'badges' ), 9 );
		add_filter( 'post_class', array( __CLASS__, 'card_class' ), 10, 3 );
	}

	public static function card_class( $classes, $css, $post_id ) {
		if ( 'product' === get_post_type( $post_id ) ) {
			$classes[] = 'wd-iran-product-card';
		}
		return $classes;
	}

	public static function badges() {
		global $product;
		if ( ! $product ) {
			return;
		}
		echo '<div class="card-badges">';
		if ( $product->is_on_sale() ) {
			$reg = (float) $product->get_regular_price();
			$sale = (float) $product->get_sale_price();
			$pct  = ( $reg > 0 && $sale > 0 ) ? round( ( ( $reg - $sale ) / $reg ) * 100 ) : 0;
			if ( $pct ) {
				echo '<span class="badge badge-special">' . esc_html( $pct ) . '٪ تخفیف</span>';
			}
		}
		if ( $product->is_in_stock() && (float) $product->get_price() >= 1500000 ) {
			echo '<span class="badge badge-shipping">ارسال رایگان</span>';
		}
		echo '</div>';
	}
}
