<?php
/**
 * Vira module: vira-price-chart
 * @package Vira
 */
namespace Vira\Modules\Price_Chart;

if ( ! defined( "ABSPATH" ) ) {
	exit;
}

class Controller {
	public static function init() {
		// ثبت تاریخچه قیمت هنگام ذخیره محصول

		add_action( "save_post_product", array( __CLASS__, "track_price" ), 20, 2 );
	}
	public static function track_price( $post_id, $post ) {
		if ( wp_is_post_revision( $post_id ) || ! function_exists( "wc_get_product" ) ) { return; }
		$p = wc_get_product( $post_id );
		if ( ! $p ) { return; }
		$hist = get_post_meta( $post_id, "_vira_price_history", true );
		if ( ! is_array( $hist ) ) { $hist = array(); }
		$hist[] = array( "date" => wp_date( "Y/m/d" ), "price" => (float) $p->get_price() );
		update_post_meta( $post_id, "_vira_price_history", array_slice( $hist, -30 ) );

	}
}
