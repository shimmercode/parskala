<?php
namespace Vira\Modules\Guest_Tracking;
if ( ! defined( 'ABSPATH' ) ) { exit; }
class Controller {
	public static function init() {
		add_shortcode( 'vira_track_order', array( __CLASS__, 'shortcode' ) );
		add_action( 'wp_footer', array( __CLASS__, 'widget' ), 40 );
	}
	public static function shortcode() {
		ob_start();
		?>
		<form class="vira-guest-track-form">
			<input type="number" name="order_id" placeholder="شماره سفارش" required>
			<input type="tel" name="mobile" placeholder="موبایل صورتحساب" required>
			<button type="submit" class="button">پیگیری</button>
			<div class="vira-track-result"></div>
		</form>
		<?php
		return ob_get_clean();
	}
	public static function widget() {
		if ( is_account_page() ) {
			return;
		}
	}
}
