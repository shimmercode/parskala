<?php
namespace Vira\Modules\Loyalty_Rewards;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'woocommerce_order_status_completed', array( __CLASS__, 'grant_points' ) );
		add_action( 'woocommerce_account_dashboard', array( __CLASS__, 'dashboard' ), 4 );
		add_action( 'wp_ajax_vira_redeem_points', array( __CLASS__, 'redeem' ) );
	}

	public static function grant_points( $order_id ) {
		$order = wc_get_order( $order_id );
		if ( ! $order || ! $order->get_user_id() ) {
			return;
		}
		$uid = $order->get_user_id();
		$add = max( 1, (int) ( $order->get_total() / 10000 ) );
		$pts = (int) get_user_meta( $uid, 'vira_points', true );
		update_user_meta( $uid, 'vira_points', $pts + $add );
		update_user_meta( $uid, '_vira_loyalty_points', $pts + $add );
	}

	public static function dashboard() {
		$pts = (int) get_user_meta( get_current_user_id(), 'vira_points', true );
		echo '<div class="vira-loyalty-box"><h3>باشگاه مشتریان</h3><p>امتیاز قابل استفاده: <b>' . (int) $pts . '</b></p>';
		if ( $pts >= 100 ) {
			echo '<p><button type="button" class="button" id="viraRedeemPts">تبدیل ۱۰۰ امتیاز به کوپن ۱۰٪</button></p>';
		}
		echo '</div><script>jQuery(function($){$("#viraRedeemPts").on("click",function(){$.post((window.viraVars&&viraVars.ajaxUrl)||ajaxurl,{action:"vira_redeem_points",security:(viraVars&&viraVars.nonce)},function(r){alert(r.data&&r.data.message?r.data.message:"انجام شد");if(r.success)location.reload();});});});</script>';
	}

	public static function redeem() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$uid = get_current_user_id();
		$pts = (int) get_user_meta( $uid, 'vira_points', true );
		if ( $pts < 100 ) {
			wp_send_json_error( array( 'message' => 'امتیاز کافی نیست.' ) );
		}
		$code = 'VIRA' . $uid . wp_rand( 10, 99 );
		$c    = new \WC_Coupon();
		$c->set_code( $code );
		$c->set_discount_type( 'percent' );
		$c->set_amount( 10 );
		$c->set_usage_limit( 1 );
		$c->set_email_restrictions( array( wp_get_current_user()->user_email ) );
		$c->save();
		update_user_meta( $uid, 'vira_points', $pts - 100 );
		wp_send_json_success( array( 'message' => 'کوپن شما: ' . $code ) );
	}
}
