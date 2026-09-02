<?php
namespace Vira\Modules\OTP_SMS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( '20-otp-sms' ) ) {
			return;
		}
		add_action( 'wp_ajax_vira_send_otp', array( __CLASS__, 'send' ) );
		add_action( 'wp_ajax_nopriv_vira_send_otp', array( __CLASS__, 'send' ) );
		add_action( 'wp_ajax_vira_verify_otp', array( __CLASS__, 'verify' ) );
		add_action( 'wp_ajax_nopriv_vira_verify_otp', array( __CLASS__, 'verify' ) );
		add_action( 'wp_footer', array( __CLASS__, 'fab' ), 30 );
	}

	public static function fab() {
		if ( is_user_logged_in() ) {
			return;
		}
		$key = get_option( 'vira_sms_api_key', '' );
		if ( ! $key && function_exists( 'prk_get_option' ) ) {
			$key = (string) prk_get_option( 'gateway_sms_panel_api_key', '' );
		}
		if ( ! $key ) {
			return;
		}
		echo '<div class="vira-otp-fab js-open-otp-modal">ورود</div>';
		echo '<div id="vira-otp-modal" class="vira-modal-overlay"><div class="vira-modal-box"><button type="button" class="vira-modal-close js-close-otp">&times;</button>';
		echo '<h3>ورود با موبایل</h3><form id="vira-otp-form"><input type="tel" name="mobile" placeholder="09xxxxxxxxx" required><button type="submit" class="button">ارسال کد</button></form></div></div>';
	}

	public static function send() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$mobile = isset( $_POST['mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['mobile'] ) ) : '';
		if ( ! preg_match( '/^09[0-9]{9}$/', $mobile ) ) {
			wp_send_json_error( array( 'message' => 'شماره موبایل معتبر نیست.' ) );
		}
		$ip   = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		$lock = 'vira_otp_lock_' . md5( $mobile . $ip );
		if ( get_transient( $lock ) ) {
			wp_send_json_error( array( 'message' => 'لطفاً کمی صبر کنید.' ) );
		}
		if ( class_exists( '\\PRK_OTP_Firewall', false ) && ! \PRK_OTP_Firewall::allow( $mobile . $ip ) ) {
			wp_send_json_error( array( 'message' => 'محدودیت تعداد درخواست.' ) );
		}
		$key = get_option( 'vira_sms_api_key', '' );
		if ( ! $key && function_exists( 'prk_get_option' ) ) {
			$key = (string) prk_get_option( 'gateway_sms_panel_api_key', '' );
			if ( $key ) {
				update_option( 'vira_sms_api_key', $key, false );
			}
		}
		if ( ! $key ) {
			wp_send_json_error( array( 'message' => 'OTP service is not configured' ) );
		}
		$code = (string) wp_rand( 10000, 99999 );
		set_transient( 'vira_otp_h_' . md5( $mobile ), wp_hash_password( $code ), 5 * MINUTE_IN_SECONDS );
		set_transient( 'vira_otp_att_' . md5( $mobile ), 0, 5 * MINUTE_IN_SECONDS );
		set_transient( $lock, 1, 45 );
		require_once get_template_directory() . '/inc/sms/class-vira-sms.php';
		$sent = \Vira_Sms::send( $mobile, 'Vira OTP: ' . $code );
		if ( true !== $sent ) {
			$msg = is_wp_error( $sent ) ? $sent->get_error_message() : 'ارسال پیامک ناموفق';
			wp_send_json_error( array( 'message' => $msg ) );
		}
		wp_send_json_success( array( 'message' => 'کد تایید ارسال شد.', 'mobile' => $mobile ) );
	}

	public static function verify() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$mobile = isset( $_POST['mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['mobile'] ) ) : '';
		$code   = isset( $_POST['code'] ) ? sanitize_text_field( wp_unslash( $_POST['code'] ) ) : '';
		$hash   = get_transient( 'vira_otp_h_' . md5( $mobile ) );
		$att    = (int) get_transient( 'vira_otp_att_' . md5( $mobile ) );
		if ( $att >= 5 ) {
			wp_send_json_error( array( 'message' => 'تلاش بیش از حد.' ) );
		}
		if ( ! $hash || ! wp_check_password( $code, $hash ) ) {
			set_transient( 'vira_otp_att_' . md5( $mobile ), $att + 1, 5 * MINUTE_IN_SECONDS );
			wp_send_json_error( array( 'message' => 'کد اشتباه یا منقضی است.' ) );
		}
		delete_transient( 'vira_otp_h_' . md5( $mobile ) );
		$users = get_users(
			array(
				'meta_key'   => 'vira_mobile',
				'meta_value' => $mobile,
				'number'     => 1,
			)
		);
		if ( ! empty( $users ) ) {
			$user_id = $users[0]->ID;
		} else {
			$user_id = wp_create_user( 'user_' . substr( $mobile, 3 ) . wp_rand( 10, 99 ), wp_generate_password(), $mobile . '@vira-store.ir' );
			if ( is_wp_error( $user_id ) ) {
				wp_send_json_error( array( 'message' => 'ایجاد حساب ناموفق.' ) );
			}
			update_user_meta( $user_id, 'vira_mobile', $mobile );
		}
		wp_clear_auth_cookie();
		wp_set_current_user( $user_id );
		wp_set_auth_cookie( $user_id, true );
		wp_send_json_success( array( 'message' => 'ورود موفق.', 'redirect' => home_url( '/' ) ) );
	}
}
