<?php
namespace Vira\Modules\Location_Selector;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( 'vira-location-selector' ) ) {
			return;
		}
		add_action( 'wp_ajax_vira_get_cities', array( __CLASS__, 'get_cities' ) );
		add_action( 'wp_ajax_nopriv_vira_get_cities', array( __CLASS__, 'get_cities' ) );
		add_action( 'wp_ajax_vira_save_location', array( __CLASS__, 'save' ) );
		add_action( 'wp_ajax_nopriv_vira_save_location', array( __CLASS__, 'save' ) );
	}

	public static function get_cities() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$province = isset( $_POST['province'] ) ? sanitize_text_field( wp_unslash( $_POST['province'] ) ) : '';
		$catalog  = vira_get_iran_provinces_cities();
		$cities   = isset( $catalog[ $province ] ) ? $catalog[ $province ] : array();
		wp_send_json_success( array( 'province' => $province, 'cities' => $cities ) );
	}

	public static function save() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$province = isset( $_POST['province'] ) ? sanitize_text_field( wp_unslash( $_POST['province'] ) ) : '';
		$city     = isset( $_POST['city'] ) ? sanitize_text_field( wp_unslash( $_POST['city'] ) ) : '';
		$data     = wp_json_encode(
			array(
				'province' => $province,
				'city'     => $city,
				'time'     => time(),
			)
		);
		setcookie( 'vira_user_location', $data, time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
		if ( is_user_logged_in() ) {
			update_user_meta( get_current_user_id(), '_vira_location', array( 'province' => $province, 'city' => $city ) );
		}
		wp_send_json_success(
			array(
				'message'  => 'موقعیت ذخیره شد.',
				'province' => $province,
				'city'     => $city,
			)
		);
	}
}
