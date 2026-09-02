<?php
if ( ! defined( "ABSPATH" ) ) { exit; }
if ( ! function_exists( "prk_send_order_sms" ) ) {
	function prk_send_order_sms( $order_id ) {
		if ( ! function_exists( "vira_send_sms" ) || ! function_exists( "wc_get_order" ) ) { return; }
		$order = wc_get_order( $order_id );
		if ( ! $order ) { return; }
		$phone = $order->get_billing_phone();
		if ( $phone ) {
			vira_send_sms( $phone, "وضعیت سفارش " . $order->get_order_number() . ": " . wc_get_order_status_name( $order->get_status() ) );
		}
	}
	add_action( "woocommerce_order_status_changed", "prk_send_order_sms" );
}
