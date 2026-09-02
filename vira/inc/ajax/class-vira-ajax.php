<?php
/**
 * Shared AJAX leftover (module-owned endpoints live in modules).
 *
 * @package Vira
 */

namespace Vira\Ajax;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ajax_Controller {
	private static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		if ( vira_is_module_enabled( 'vira-price-chart' ) ) {
			add_action( 'wp_ajax_vira_get_price_chart', array( $this, 'chart' ) );
			add_action( 'wp_ajax_nopriv_vira_get_price_chart', array( $this, 'chart' ) );
		}
		if ( vira_is_module_enabled( 'vira-loyalty-rewards' ) ) {
			add_action( 'wp_ajax_vira_convert_points_coupon', array( $this, 'points' ) );
		}
	}

	private function verify() {
		if ( ! check_ajax_referer( 'vira_ajax_nonce', 'security', false ) ) {
			wp_send_json_error( array( 'message' => 'امنیت' ), 403 );
		}
	}

	public function chart() {
		$this->verify();
		$product_id = isset( $_GET['product_id'] ) ? absint( $_GET['product_id'] ) : 0;
		$history    = get_post_meta( $product_id, '_vira_price_history', true );
		if ( ! is_array( $history ) || empty( $history ) ) {
			$current = (float) get_post_meta( $product_id, '_price', true );
			$history = array(
				array(
					'date'  => date( 'Y/m/d' ),
					'price' => $current,
				),
			);
		}
		wp_send_json_success(
			array(
				'labels' => wp_list_pluck( $history, 'date' ),
				'prices' => wp_list_pluck( $history, 'price' ),
			)
		);
	}

	public function points() {
		$this->verify();
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'وارد شوید.' ) );
		}
		$user_id = get_current_user_id();
		$points  = (int) get_user_meta( $user_id, '_vira_loyalty_points', true );
		if ( $points < 100 ) {
			wp_send_json_error( array( 'message' => 'حداقل ۱۰۰ امتیاز.' ) );
		}
		$code = 'VIRA-' . strtoupper( wp_generate_password( 6, false ) );
		$c    = new \WC_Coupon();
		$c->set_code( $code );
		$c->set_discount_type( 'fixed_cart' );
		$c->set_amount( $points * 1000 );
		$c->set_usage_limit( 1 );
		$c->save();
		update_user_meta( $user_id, '_vira_loyalty_points', 0 );
		wp_send_json_success( array( 'coupon' => $code ) );
	}

	public function track() {
		$this->verify();
		$order_id = isset( $_POST['order_id'] ) ? absint( $_POST['order_id'] ) : 0;
		$mobile   = isset( $_POST['mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['mobile'] ) ) : '';
		$order    = wc_get_order( $order_id );
		if ( ! $order ) {
			wp_send_json_error( array( 'message' => 'یافت نشد.' ) );
		}
		$phone = preg_replace( '/\D+/', '', $order->get_billing_phone() );
		$in    = preg_replace( '/\D+/', '', $mobile );
		if ( $phone === '' || $in === '' || substr( $phone, -10 ) !== substr( $in, -10 ) ) {
			wp_send_json_error( array( 'message' => 'اطلاعات مطابقت ندارد.' ) );
		}
		$items = array();
		foreach ( $order->get_items() as $item ) {
			$items[] = $item->get_name() . ' × ' . $item->get_quantity();
		}
		wp_send_json_success(
			array(
				'status'   => wc_get_order_status_name( $order->get_status() ),
				'total'    => vira_format_toman( $order->get_total() ),
				'date'     => wc_format_datetime( $order->get_date_created() ),
				'items'    => $items,
				'shipping' => $order->get_shipping_method(),
				'tracking' => $order->get_meta( '_vira_tracking' ),
			)
		);
	}
}

Ajax_Controller::get_instance();
