<?php
if ( ! defined( "ABSPATH" ) ) { exit; }
if ( ! class_exists( "PRK_OTP_Firewall" ) ) {
	class PRK_OTP_Firewall {
		public static function allow( $key ) { return true; }
	}
}
