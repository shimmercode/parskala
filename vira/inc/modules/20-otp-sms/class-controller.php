<?php
namespace Vira\Modules\OTP_SMS;
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Controller {
	public static function init() {
		add_action( 'wp_footer', array( __CLASS__, 'hint' ), 30 );
	}
	public static function hint() {
		if ( is_user_logged_in() ) {
			return;
		}
		echo '<div class="vira-otp-fab js-open-otp-modal" title="ورود پیامکی">ورود</div>';
	}
}
