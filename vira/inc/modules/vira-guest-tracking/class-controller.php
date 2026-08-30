<?php
namespace Vira\Modules\Guest_Tracking;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( 'vira-guest-tracking' ) ) {
			return;
		}
		add_shortcode( 'vira_track_order', array( __CLASS__, 'shortcode' ) );
		add_action( 'init', array( __CLASS__, 'ensure_page' ) );
	}

	public static function ensure_page() {
		if ( get_option( 'vira_track_page_id' ) ) {
			return;
		}
		$id = wp_insert_post(
			array(
				'post_title'   => 'پیگیری سفارش',
				'post_name'    => 'order-tracking',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_content' => '[vira_track_order]',
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_option( 'vira_track_page_id', $id );
		}
	}

	public static function shortcode() {
		ob_start();
		echo '<form class="vira-guest-track-form">';
		echo '<input type="number" name="order_id" placeholder="شماره سفارش" required>';
		echo '<input type="tel" name="mobile" placeholder="موبایل صورتحساب" required>';
		echo '<button type="submit" class="button">پیگیری</button>';
		echo '<div class="vira-track-result"></div></form>';
		return ob_get_clean();
	}
}
