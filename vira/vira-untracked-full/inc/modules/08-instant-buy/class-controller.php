<?php
namespace Vira\Modules\Instant_Buy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( '08-instant-buy' ) ) {
			return;
		}
		add_action( 'woocommerce_after_add_to_cart_button', array( __CLASS__, 'button' ), 15 );
		add_action( 'wp_ajax_vira_instant_buy', array( __CLASS__, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_vira_instant_buy', array( __CLASS__, 'ajax' ) );
	}

	public static function button() {
		global $product;
		if ( ! $product || ! $product->is_in_stock() ) {
			return;
		}
		echo '<button type="button" class="vira-instant-buy-btn button alt" data-product-id="' . esc_attr( $product->get_id() ) . '" data-type="' . esc_attr( $product->get_type() ) . '">خرید فوری</button>';
	}

	public static function ajax() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
			wp_send_json_error( array( 'message' => 'سبد در دسترس نیست.' ), 400 );
		}
		$product_id   = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
		$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
		$qty          = isset( $_POST['qty'] ) ? max( 1, absint( $_POST['qty'] ) ) : 1;
		$product      = wc_get_product( $product_id );
		if ( ! $product ) {
			wp_send_json_error( array( 'message' => 'محصول نامعتبر است.' ), 400 );
		}
		if ( $product->is_type( 'variable' ) && ! $variation_id ) {
			wp_send_json_error( array( 'message' => 'ابتدا ویژگی محصول را انتخاب کنید.' ), 400 );
		}
		$added = WC()->cart->add_to_cart( $product_id, $qty, $variation_id );
		if ( ! $added ) {
			wp_send_json_error( array( 'message' => 'افزودن به سبد ناموفق بود.' ), 400 );
		}
		wp_send_json_success( array( 'redirect' => wc_get_checkout_url() ) );
	}
}
