<?php
/**
 * Checkout map picker (Leaflet).
 *
 * @package Vira
 */

namespace Vira\Modules\Map_Address;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'woocommerce_after_checkout_billing_form', array( __CLASS__, 'map' ) );
		add_action( 'woocommerce_checkout_update_order_meta', array( __CLASS__, 'save' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'assets' ) );
	}

	public static function assets() {
		if ( ! function_exists( 'is_checkout' ) || ! is_checkout() ) {
			return;
		}
		$dir = get_template_directory();
		$uri = get_template_directory_uri();
		if ( file_exists( $dir . '/assets/css/leaflet.css' ) ) {
			wp_enqueue_style( 'leaflet', $uri . '/assets/css/leaflet.css', array(), VIRA_THEME_VERSION );
		}
		if ( file_exists( $dir . '/assets/js/leaflet.js' ) ) {
			wp_enqueue_script( 'leaflet', $uri . '/assets/js/leaflet.js', array(), VIRA_THEME_VERSION, true );
		}
	}

	public static function map() {
		?>
		<div class="vira-map-address">
			<h3>موقعیت روی نقشه</h3>
			<p>روی نقشه کلیک کنید تا طول و عرض جغرافیایی ذخیره شود.</p>
			<div id="vira-checkout-map" style="height:260px;border-radius:12px;"></div>
			<input type="hidden" name="vira_lat" id="vira_lat">
			<input type="hidden" name="vira_lng" id="vira_lng">
		</div>
		<?php
	}

	public static function save( $order_id ) {
		if ( isset( $_POST['vira_lat'] ) ) {
			update_post_meta( $order_id, '_vira_lat', sanitize_text_field( wp_unslash( $_POST['vira_lat'] ) ) );
		}
		if ( isset( $_POST['vira_lng'] ) ) {
			update_post_meta( $order_id, '_vira_lng', sanitize_text_field( wp_unslash( $_POST['vira_lng'] ) ) );
		}
	}
}
