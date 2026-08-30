<?php
/**
 * OTP rate limiter (readable reconstruction).
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PRK_OTP_Firewall {
	public static function allow( $key ) {
		$key  = 'vira_fw_' . md5( (string) $key );
		$hits = (int) get_transient( $key );
		if ( $hits >= 8 ) {
			return false;
		}
		set_transient( $key, $hits + 1, 10 * MINUTE_IN_SECONDS );
		return true;
	}
}
