<?php
/**
 * Vira module: 16-iran-checkout
 * @package Vira
 */
namespace Vira\Modules\Iran_Checkout;

if ( ! defined( "ABSPATH" ) ) {
	exit;
}

class Controller {
	public static function init() {
		// فیلدهای تسویه ایران

		add_filter( "woocommerce_checkout_fields", array( __CLASS__, "fields" ) );
	}
	public static function fields( $fields ) {
		$fields["billing"]["billing_national_id"] = array(
			"label" => "کد ملی",
			"required" => false,
			"class" => array("form-row-wide"),
			"priority" => 25,
		);
		$fields["billing"]["billing_phone"]["required"] = true;
		return $fields;

	}
}
