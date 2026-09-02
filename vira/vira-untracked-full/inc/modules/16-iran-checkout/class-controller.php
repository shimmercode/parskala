<?php
namespace Vira\Modules\Iran_Checkout;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( '16-iran-checkout' ) ) {
			return;
		}
		add_filter( 'woocommerce_checkout_fields', array( __CLASS__, 'fields' ) );
		add_action( 'woocommerce_checkout_process', array( __CLASS__, 'validate' ) );
		add_action( 'woocommerce_checkout_update_order_meta', array( __CLASS__, 'save' ) );
	}

	public static function fields( $fields ) {
		$fields['billing']['billing_national_id'] = array(
			'label'    => 'کد ملی',
			'required' => true,
			'class'    => array( 'form-row-wide' ),
			'priority' => 25,
		);
		$fields['billing']['billing_postcode']['required'] = true;
		$fields['billing']['billing_postcode']['label']    = 'کد پستی ۱۰ رقمی';
		return $fields;
	}

	public static function is_valid_national_id( $code ) {
		$code = preg_replace( '/\D+/', '', $code );
		if ( ! preg_match( '/^\d{10}$/', $code ) ) {
			return false;
		}
		if ( preg_match( '/^(\d)\1{9}$/', $code ) ) {
			return false;
		}
		$check = (int) $code[9];
		$sum   = 0;
		for ( $i = 0; $i < 9; $i++ ) {
			$sum += (int) $code[ $i ] * ( 10 - $i );
		}
		$r = $sum % 11;
		return ( $r < 2 && $check === $r ) || ( $r >= 2 && $check === ( 11 - $r ) );
	}

	public static function validate() {
		$nid = isset( $_POST['billing_national_id'] ) ? sanitize_text_field( wp_unslash( $_POST['billing_national_id'] ) ) : '';
		$pc  = isset( $_POST['billing_postcode'] ) ? sanitize_text_field( wp_unslash( $_POST['billing_postcode'] ) ) : '';
		if ( ! self::is_valid_national_id( $nid ) ) {
			wc_add_notice( 'کد ملی معتبر نیست.', 'error' );
		}
		if ( ! preg_match( '/^\d{10}$/', preg_replace( '/\D+/', '', $pc ) ) ) {
			wc_add_notice( 'کد پستی باید ۱۰ رقم باشد.', 'error' );
		}
	}

	public static function save( $order_id ) {
		if ( isset( $_POST['billing_national_id'] ) ) {
			update_post_meta( $order_id, '_billing_national_id', sanitize_text_field( wp_unslash( $_POST['billing_national_id'] ) ) );
		}
	}
}
