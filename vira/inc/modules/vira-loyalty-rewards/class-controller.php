<?php
/**
 * Vira module: vira-loyalty-rewards
 * @package Vira
 */
namespace Vira\Modules\Loyalty_Rewards;

if ( ! defined( "ABSPATH" ) ) {
	exit;
}

class Controller {
	public static function init() {
		// امتیاز سفارش تکمیل‌شده

		add_action( "woocommerce_order_status_completed", array( __CLASS__, "grant_points" ) );
	}
	public static function grant_points( $order_id ) {
		$order = wc_get_order( $order_id );
		if ( ! $order || ! $order->get_user_id() ) { return; }
		$pts = (int) get_user_meta( $order->get_user_id(), "_vira_loyalty_points", true );
		update_user_meta( $order->get_user_id(), "_vira_loyalty_points", $pts + (int) $order->get_total() );

	}
}
