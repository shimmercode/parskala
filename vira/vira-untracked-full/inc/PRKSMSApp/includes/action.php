<?php
if ( ! defined( "ABSPATH" ) ) { exit; }
if ( ! class_exists( "PRKSMSAppClass" ) ) {
	class PRKSMSAppClass {
		public static function getLog() { return array(); }
		public static function send( $mobile, $message ) {
			return function_exists( "vira_send_sms" ) ? vira_send_sms( $mobile, $message ) : false;
		}
	}
}
