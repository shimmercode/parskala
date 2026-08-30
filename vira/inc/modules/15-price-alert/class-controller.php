<?php
namespace Vira\Modules\Price_Alert;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( '15-price-alert' ) ) {
			return;
		}
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'form' ), 36 );
		add_action( 'wp_ajax_vira_price_alert', array( __CLASS__, 'subscribe' ) );
		add_action( 'wp_ajax_nopriv_vira_price_alert', array( __CLASS__, 'subscribe' ) );
		add_action( 'save_post_product', array( __CLASS__, 'trigger' ), 30, 2 );
	}

	public static function form() {
		global $product;
		if ( ! $product ) {
			return;
		}
		echo '<form class="vira-price-alert-form" data-product="' . esc_attr( $product->get_id() ) . '">';
		echo '<p>هشدار کاهش قیمت</p>';
		echo '<input type="tel" name="mobile" placeholder="0912…" required pattern="09[0-9]{9}">';
		echo '<input type="number" name="target" placeholder="قیمت هدف (تومان)" min="1">';
		echo '<button type="submit" class="button">ثبت</button></form>';
	}

	public static function subscribe() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$pid    = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
		$mobile = isset( $_POST['mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['mobile'] ) ) : '';
		$target = isset( $_POST['target'] ) ? absint( $_POST['target'] ) : 0;
		if ( ! $pid || ! preg_match( '/^09[0-9]{9}$/', $mobile ) ) {
			wp_send_json_error( array( 'message' => 'ورودی نامعتبر.' ) );
		}
		$list = get_post_meta( $pid, '_vira_price_alerts', true );
		if ( ! is_array( $list ) ) {
			$list = array();
		}
		$list[ $mobile ] = array(
			'target' => $target,
			'time'   => time(),
			'queued' => false,
		);
		update_post_meta( $pid, '_vira_price_alerts', $list );
		wp_send_json_success( array( 'message' => 'هشدار ثبت شد. ارسال پیامک فقط پس از پیکربندی درگاه.' ) );
	}

	public static function trigger( $post_id, $post ) {
		if ( wp_is_post_revision( $post_id ) || ! function_exists( 'wc_get_product' ) ) {
			return;
		}
		$p = wc_get_product( $post_id );
		if ( ! $p ) {
			return;
		}
		$now  = (float) $p->get_price();
		$list = get_post_meta( $post_id, '_vira_price_alerts', true );
		if ( ! is_array( $list ) ) {
			return;
		}
		foreach ( $list as $mobile => $row ) {
			$target = is_array( $row ) ? (float) $row['target'] : 0;
			if ( $target > 0 && $now > $target ) {
				continue;
			}
			if ( $target <= 0 ) {
				continue;
			}
			if ( ! get_option( 'vira_sms_api_key', '' ) ) {
				$list[ $mobile ]['queued'] = true;
				continue;
			}
			$sent = function_exists( 'vira_send_sms' ) ? vira_send_sms( $mobile, 'کاهش قیمت به ' . $now ) : false;
			if ( true === $sent ) {
				unset( $list[ $mobile ] );
			} else {
				$list[ $mobile ]['queued'] = true;
			}
		}
		update_post_meta( $post_id, '_vira_price_alerts', $list );
	}
}
