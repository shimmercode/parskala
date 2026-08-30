<?php
namespace Vira\Modules\Map_Address;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( '17-map-address' ) ) {
			return;
		}
		add_action( 'woocommerce_after_checkout_billing_form', array( __CLASS__, 'map' ) );
		add_action( 'woocommerce_checkout_update_order_meta', array( __CLASS__, 'save' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'assets' ) );
		add_action( 'wp_ajax_vira_reverse_geo', array( __CLASS__, 'reverse' ) );
		add_action( 'wp_ajax_nopriv_vira_reverse_geo', array( __CLASS__, 'reverse' ) );
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
			<p>روی نقشه کلیک کنید. آدرس را دستی تکمیل کنید مگر geocoding در پنل فعال باشد.</p>
			<div id="vira-checkout-map" style="height:260px;border-radius:12px;"></div>
			<input type="hidden" name="vira_lat" id="vira_lat">
			<input type="hidden" name="vira_lng" id="vira_lng">
			<p><label>آدرس تکمیلی <input type="text" name="vira_manual_address" class="input-text"></label></p>
		</div>
		<?php
	}

	public static function reverse() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		require_once get_template_directory() . '/inc/geocoding/class-vira-geocoding.php';
		$lat = isset( $_POST['lat'] ) ? floatval( $_POST['lat'] ) : 0;
		$lng = isset( $_POST['lng'] ) ? floatval( $_POST['lng'] ) : 0;
		$geo = new \Vira_Geocoding_Nominatim();
		$out = $geo->reverse( $lat, $lng );
		if ( is_wp_error( $out ) ) {
			wp_send_json_error( array( 'message' => $out->get_error_message() ) );
		}
		wp_send_json_success( $out );
	}

	public static function save( $order_id ) {
		foreach ( array( 'vira_lat', 'vira_lng', 'vira_manual_address' ) as $k ) {
			if ( isset( $_POST[ $k ] ) ) {
				update_post_meta( $order_id, '_' . $k, sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) );
			}
		}
	}
}
