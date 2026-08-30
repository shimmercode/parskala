<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WCQV_Backend {
	public function __construct() {
		add_action( 'wp_ajax_vira_quick_view', array( $this, 'html' ) );
		add_action( 'wp_ajax_nopriv_vira_quick_view', array( $this, 'html' ) );
		add_action( 'wp_ajax_vira_qv_add', array( $this, 'add' ) );
		add_action( 'wp_ajax_nopriv_vira_qv_add', array( $this, 'add' ) );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'button' ), 15 );
	}

	public function button() {
		global $product;
		if ( ! $product ) {
			return;
		}
		echo '<button type="button" class="vira-quick-view" data-id="' . esc_attr( $product->get_id() ) . '">مشاهده سریع</button>';
	}

	public function html() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$p = wc_get_product( isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0 );
		if ( ! $p ) {
			wp_send_json_error();
		}
		ob_start();
		echo '<div class="vira-qv" data-id="' . esc_attr( $p->get_id() ) . '" data-type="' . esc_attr( $p->get_type() ) . '">';
		echo $p->get_image( 'woocommerce_single' ); // phpcs:ignore
		echo '<h3>' . esc_html( $p->get_name() ) . '</h3>';
		echo '<div class="price">' . wp_kses_post( $p->get_price_html() ) . '</div>';
		echo '<div class="desc">' . wp_kses_post( wp_trim_words( $p->get_short_description(), 40 ) ) . '</div>';
		if ( $p->is_type( 'variable' ) ) {
			foreach ( $p->get_variation_attributes() as $attr => $values ) {
				$label = wc_attribute_label( $attr );
				echo '<p><label>' . esc_html( $label ) . '<select class="vira-qv-attr" name="' . esc_attr( $attr ) . '">';
				echo '<option value="">انتخاب</option>';
				foreach ( $values as $v ) {
					echo '<option value="' . esc_attr( $v ) . '">' . esc_html( $v ) . '</option>';
				}
				echo '</select></label></p>';
			}
			$map = array();
			foreach ( $p->get_available_variations() as $var ) {
				$map[] = array(
					'id'         => $var['variation_id'],
					'attrs'      => $var['attributes'],
					'is_in_stock'=> ! empty( $var['is_in_stock'] ),
					'price_html' => $var['price_html'],
				);
			}
			echo '<script type="application/json" class="vira-qv-vars">' . wp_json_encode( $map ) . '</script>';
		}
		echo '<p><input type="number" class="vira-qv-qty" value="1" min="1"></p>';
		echo '<button type="button" class="button vira-qv-add">افزودن به سبد</button>';
		echo '</div>';
		wp_send_json_success( array( 'html' => ob_get_clean() ) );
	}

	public function add() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
			wp_send_json_error( array( 'message' => 'سبد نیست' ) );
		}
		$pid = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
		$vid = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;
		$qty = isset( $_POST['qty'] ) ? max( 1, absint( $_POST['qty'] ) ) : 1;
		$p   = wc_get_product( $pid );
		if ( ! $p ) {
			wp_send_json_error( array( 'message' => 'محصول نامعتبر' ) );
		}
		if ( $p->is_type( 'variable' ) && ! $vid ) {
			wp_send_json_error( array( 'message' => 'ویژگی را انتخاب کنید' ) );
		}
		$ok = WC()->cart->add_to_cart( $pid, $qty, $vid );
		if ( ! $ok ) {
			wp_send_json_error( array( 'message' => 'افزودن ناموفق' ) );
		}
		wp_send_json_success( array( 'cart' => wc_get_cart_url() ) );
	}
}

new WCQV_Backend();
