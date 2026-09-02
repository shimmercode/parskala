<?php
/**
 * Legacy auth bootstrap — OTP lives in Vira\\Modules\\OTP_SMS.
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PRK_Auth {
	public static function init() {
		require_once dirname( __FILE__ ) . '/PRK_OTP_Firewall.php';
	}
}

PRK_Auth::init();
