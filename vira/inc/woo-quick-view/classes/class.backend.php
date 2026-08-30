<?php
/**
 * Quick view (ionCube replacement — real AJAX).
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCQV_Backend {
	public function __construct() {
		add_action( 'wp_ajax_vira_quick_view', array( $this, 'html' ) );
		add_action( 'wp_ajax_nopriv_vira_quick_view', array( $this, 'html' ) );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'button' ), 15 );
	}

	public function button() {
		if ( ! function_exists( 'vira_is_module_enabled' ) ) {
			return;
		}
		global $product;
		if ( ! $product ) {
			return;
		}
		echo '<button type="button" class="vira-quick-view" data-id="' . esc_attr( $product->get_id() ) . '">مشاهده سریع</button>';
	}

	public function html() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$id = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;
		$p  = wc_get_product( $id );
		if ( ! $p ) {
			wp_send_json_error();
		}
		ob_start();
		echo '<div class="vira-qv"><h3>' . esc_html( $p->get_name() ) . '</h3>';
		echo $p->get_image(); // phpcs:ignore
		echo '<div class="price">' . wp_kses_post( $p->get_price_html() ) . '</div>';
		echo '<a class="button" href="' . esc_url( $p->get_permalink() ) . '">صفحه محصول</a></div>';
		wp_send_json_success( array( 'html' => ob_get_clean() ) );
	}
}

new WCQV_Backend();
