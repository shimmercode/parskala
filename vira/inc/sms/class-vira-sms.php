<?php
/**
 * SMS gateway abstraction — PHP 7.4.
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Vira_Sms_Gateway_Interface {
	/**
	 * @param string $mobile
	 * @param string $message
	 * @return bool|WP_Error
	 */
	public function send( $mobile, $message );
}

class Vira_Sms_Kavenegar implements Vira_Sms_Gateway_Interface {
	public function send( $mobile, $message ) {
		$api = get_option( 'vira_sms_api_key', '' );
		if ( ! $api ) {
			return new WP_Error( 'sms_unconfigured', 'OTP service is not configured' );
		}
		$url  = 'https://api.kavenegar.com/v1/' . rawurlencode( $api ) . '/sms/send.json';
		$resp = wp_remote_post(
			$url,
			array(
				'timeout' => 15,
				'body'    => array(
					'receptor' => $mobile,
					'message'  => $message,
					'sender'   => get_option( 'vira_sms_sender', '' ),
				),
			)
		);
		if ( is_wp_error( $resp ) ) {
			return $resp;
		}
		$code = wp_remote_retrieve_response_code( $resp );
		if ( $code < 200 || $code >= 300 ) {
			return new WP_Error( 'sms_http', 'SMS gateway HTTP ' . $code );
		}
		return true;
	}
}

class Vira_Sms {
	/**
	 * @return Vira_Sms_Gateway_Interface
	 */
	public static function gateway() {
		$g = get_option( 'vira_sms_gateway', 'kavenegar' );
		return new Vira_Sms_Kavenegar();
	}

	public static function send( $mobile, $message ) {
		$result = self::gateway()->send( $mobile, $message );
		if ( true === $result ) {
			do_action( 'vira_sms_sent', $mobile );
			return true;
		}
		return $result;
	}
}
