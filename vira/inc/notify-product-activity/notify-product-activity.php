<?php
/**
 * Back-in-stock / activity notify queue.
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function prk_stock_notify_boot() {
	add_action( 'woocommerce_product_set_stock_status', 'vira_stock_notify_status', 10, 3 );
}

function vira_stock_notify_status( $product_id, $stock_status, $product ) {
	if ( 'instock' !== $stock_status ) {
		return;
	}
	$list = get_post_meta( $product_id, '_vira_stock_wait', true );
	if ( ! is_array( $list ) ) {
		return;
	}
	foreach ( $list as $mobile ) {
		if ( get_option( 'vira_sms_api_key', '' ) && function_exists( 'vira_send_sms' ) ) {
			vira_send_sms( $mobile, 'موجود شد: محصول #' . $product_id );
		}
	}
}

add_action( 'init', 'prk_stock_notify_boot' );
