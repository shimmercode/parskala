<?php
namespace Vira\Modules\Bundle_Discount;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( '10-bundle-discount' ) ) {
			return;
		}
		add_action( 'woocommerce_after_single_product_summary', array( __CLASS__, 'render' ), 12 );
		add_action( 'wp_ajax_vira_add_bundle', array( __CLASS__, 'add_bundle' ) );
		add_action( 'wp_ajax_nopriv_vira_add_bundle', array( __CLASS__, 'add_bundle' ) );
		add_action( 'init', array( __CLASS__, 'ensure_coupon' ) );
	}

	public static function ensure_coupon() {
		if ( ! function_exists( 'wc_get_coupon_id_by_code' ) ) {
			return;
		}
		if ( wc_get_coupon_id_by_code( 'VIRA-BUNDLE-10' ) ) {
			return;
		}
		$c = new \WC_Coupon();
		$c->set_code( 'VIRA-BUNDLE-10' );
		$c->set_discount_type( 'percent' );
		$c->set_amount( 10 );
		$c->set_individual_use( false );
		$c->set_usage_limit_per_user( 5 );
		$c->save();
	}

	public static function render() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$related = wc_get_related_products( $product->get_id(), 3 );
		if ( ! $related ) {
			return;
		}
		$ids = array_merge( array( $product->get_id() ), $related );
		echo '<section class="vira-bundle-box"><h3>پکیج با کوپن ۱۰٪</h3><ul class="vira-bundle-list">';
		foreach ( $ids as $id ) {
			$p = wc_get_product( $id );
			if ( ! $p ) {
				continue;
			}
			echo '<li>' . $p->get_image( 'woocommerce_gallery_thumbnail' ) . '<span>' . esc_html( $p->get_name() ) . '</span></li>'; // phpcs:ignore
		}
		echo '</ul><button type="button" class="button vira-add-bundle" data-ids="' . esc_attr( implode( ',', $ids ) ) . '">افزودن پکیج + کوپن ۱۰٪</button></section>';
	}

	public static function add_bundle() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		if ( ! WC()->cart ) {
			wp_send_json_error();
		}
		$ids = isset( $_POST['ids'] ) ? array_filter( array_map( 'absint', explode( ',', sanitize_text_field( wp_unslash( $_POST['ids'] ) ) ) ) ) : array();
		if ( count( $ids ) < 2 ) {
			wp_send_json_error( array( 'message' => 'حداقل دو کالا لازم است.' ) );
		}
		foreach ( $ids as $id ) {
			WC()->cart->add_to_cart( $id, 1 );
		}
		WC()->cart->apply_coupon( 'VIRA-BUNDLE-10' );
		wp_send_json_success( array( 'redirect' => wc_get_cart_url() ) );
	}
}
