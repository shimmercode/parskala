<?php
/**
 * Price drop alerts.
 *
 * @package Vira
 */

namespace Vira\Modules\Price_Alert;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'form' ), 36 );
		add_action( 'wp_ajax_vira_price_alert', array( __CLASS__, 'subscribe' ) );
		add_action( 'wp_ajax_nopriv_vira_price_alert', array( __CLASS__, 'subscribe' ) );
		add_action( 'save_post_product', array( __CLASS__, 'notify' ), 30, 2 );
	}

	public static function form() {
		global $product;
		if ( ! $product ) {
			return;
		}
		?>
		<form class="vira-price-alert-form" data-product="<?php echo esc_attr( $product->get_id() ); ?>">
			<p>اگر قیمت پایین آمد خبرم کن</p>
			<input type="tel" name="mobile" placeholder="0912…" required pattern="09[0-9]{9}">
			<button type="submit" class="button">ثبت هشدار</button>
		</form>
		<?php
	}

	public static function subscribe() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$pid    = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
		$mobile = isset( $_POST['mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['mobile'] ) ) : '';
		if ( ! $pid || ! preg_match( '/^09[0-9]{9}$/', $mobile ) ) {
			wp_send_json_error( array( 'message' => 'شماره یا محصول نامعتبر است.' ) );
		}
		$list = get_post_meta( $pid, '_vira_price_alerts', true );
		if ( ! is_array( $list ) ) {
			$list = array();
		}
		$list[ $mobile ] = time();
		update_post_meta( $pid, '_vira_price_alerts', $list );
		wp_send_json_success( array( 'message' => 'هشدار قیمت ثبت شد.' ) );
	}

	public static function notify( $post_id, $post ) {
		if ( wp_is_post_revision( $post_id ) || ! function_exists( 'wc_get_product' ) ) {
			return;
		}
		$p = wc_get_product( $post_id );
		if ( ! $p ) {
			return;
		}
		$old  = (float) get_post_meta( $post_id, '_vira_last_alert_price', true );
		$now  = (float) $p->get_price();
		update_post_meta( $post_id, '_vira_last_alert_price', $now );
		if ( ! $old || $now >= $old ) {
			return;
		}
		$list = get_post_meta( $post_id, '_vira_price_alerts', true );
		if ( ! is_array( $list ) ) {
			return;
		}
		foreach ( array_keys( $list ) as $mobile ) {
			if ( function_exists( 'vira_send_sms' ) ) {
				vira_send_sms( $mobile, 'کاهش قیمت: ' . $p->get_name() . ' — ' . $now );
			}
		}
	}
}
