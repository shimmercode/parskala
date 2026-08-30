<?php
namespace Vira\Modules\Trust_Modals;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( 'vira-trust-modals' ) ) {
			return;
		}
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'buttons' ), 35 );
		add_action( 'wp_ajax_vira_submit_trust_report', array( __CLASS__, 'submit' ) );
		add_action( 'wp_ajax_nopriv_vira_submit_trust_report', array( __CLASS__, 'submit' ) );
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
	}

	public static function buttons() {
		global $product;
		if ( ! $product ) {
			return;
		}
		echo '<div class="vira-trust-modals-row">';
		echo '<a href="#" class="vira-trust-link js-open-better-price" data-product-id="' . esc_attr( $product->get_id() ) . '">پیشنهاد قیمت بهتر</a> ';
		echo '<a href="#" class="vira-trust-link js-open-problem-report" data-product-id="' . esc_attr( $product->get_id() ) . '">گزارش مشکل</a>';
		echo '</div>';
	}

	public static function submit() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		if ( get_transient( 'vira_trust_' . md5( $ip ) ) ) {
			wp_send_json_error( array( 'message' => 'کمی صبر کنید.' ) );
		}
		$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
		$type       = isset( $_POST['type'] ) ? sanitize_key( wp_unslash( $_POST['type'] ) ) : 'problem_report';
		$content    = isset( $_POST['content'] ) ? sanitize_textarea_field( wp_unslash( $_POST['content'] ) ) : '';
		if ( ! $product_id || $content === '' ) {
			wp_send_json_error( array( 'message' => 'فیلدها ناقص است.' ) );
		}
		$allowed = array( 'better_price', 'problem_report', 'inappropriate' );
		if ( ! in_array( $type, $allowed, true ) ) {
			$type = 'problem_report';
		}
		$reports   = get_option( 'vira_trust_reports', array() );
		$reports[] = array(
			'product_id' => $product_id,
			'type'       => $type,
			'content'    => $content,
			'user_id'    => get_current_user_id(),
			'date'       => current_time( 'mysql' ),
		);
		update_option( 'vira_trust_reports', array_slice( $reports, -200 ), false );
		set_transient( 'vira_trust_' . md5( $ip ), 1, 60 );
		wp_send_json_success( array( 'message' => 'گزارش ثبت شد.' ) );
	}

	public static function admin_menu() {
		add_submenu_page( 'vira-admin-dashboard', 'گزارش‌های اعتماد', 'گزارش‌ها', 'manage_options', 'vira-trust-reports', array( __CLASS__, 'admin' ) );
	}

	public static function admin() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$reports = get_option( 'vira_trust_reports', array() );
		echo '<div class="wrap"><h1>گزارش کاربران</h1><table class="widefat"><thead><tr><th>محصول</th><th>نوع</th><th>متن</th><th>تاریخ</th></tr></thead><tbody>';
		foreach ( array_reverse( $reports ) as $r ) {
			echo '<tr><td>' . esc_html( $r['product_id'] ) . '</td><td>' . esc_html( $r['type'] ) . '</td><td>' . esc_html( $r['content'] ) . '</td><td>' . esc_html( $r['date'] ) . '</td></tr>';
		}
		echo '</tbody></table></div>';
	}
}
