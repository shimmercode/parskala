<?php
/**
 * Vira module: 18-tiered-pricing
 * @package Vira
 */
namespace Vira\Modules\Tiered_Pricing;

if ( ! defined( "ABSPATH" ) ) {
	exit;
}

class Controller {
	public static function init() {
		// قیمت پلکانی

		add_filter( "woocommerce_product_get_price", array( __CLASS__, "tier" ), 20, 2 );
	}
	public static function tier( $price, $product ) {
		if ( ! is_user_logged_in() || ! $product ) { return $price; }
		$qty = 1;
		if ( function_exists("WC") && WC()->cart ) {
			foreach ( WC()->cart->get_cart() as $item ) {
				if ( (int) $item["product_id"] === (int) $product->get_id() ) { $qty = (int) $item["quantity"]; }
			}
		}
		if ( $qty >= 10 ) { return (float) $price * 0.9; }
		if ( $qty >= 5 ) { return (float) $price * 0.95; }
		return $price;

	}
}
