<?php
/**
 * Save for later.
 *
 * @package Vira
 */

namespace Vira\Modules\Next_Shopping;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_filter( 'woocommerce_cart_item_name', array( __CLASS__, 'link' ), 20, 3 );
		add_action( 'wp_ajax_vira_save_later', array( __CLASS__, 'save' ) );
		add_action( 'woocommerce_after_cart', array( __CLASS__, 'list' ) );
		add_action( 'woocommerce_account_dashboard', array( __CLASS__, 'list' ) );
	}

	public static function get() {
		if ( ! is_user_logged_in() ) {
			return array();
		}
		$ids = get_user_meta( get_current_user_id(), '_vira_save_later', true );
		return is_array( $ids ) ? $ids : array();
	}

	public static function link( $name, $cart_item, $cart_item_key ) {
		if ( is_cart() && is_user_logged_in() ) {
			$name .= ' <button type="button" class="vira-save-later" data-key="' . esc_attr( $cart_item_key ) . '" data-id="' . esc_attr( $cart_item['product_id'] ) . '">ذخیره برای بعد</button>';
		}
		return $name;
	}

	public static function save() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		if ( ! is_user_logged_in() || ! WC()->cart ) {
			wp_send_json_error();
		}
		$key = isset( $_POST['key'] ) ? sanitize_text_field( wp_unslash( $_POST['key'] ) ) : '';
		$id  = isset( $_POST['id'] ) ? absint( $_POST['id'] ) : 0;
		$ids = self::get();
		$ids[] = $id;
		update_user_meta( get_current_user_id(), '_vira_save_later', array_unique( $ids ) );
		WC()->cart->remove_cart_item( $key );
		wp_send_json_success();
	}

	public static function list() {
		$ids = self::get();
		if ( ! $ids ) {
			return;
		}
		echo '<section class="vira-next-shopping"><h3>خرید بعدی</h3><ul>';
		foreach ( $ids as $id ) {
			$p = wc_get_product( $id );
			if ( ! $p ) {
				continue;
			}
			echo '<li><a href="' . esc_url( $p->get_permalink() ) . '">' . esc_html( $p->get_name() ) . '</a></li>';
		}
		echo '</ul></section>';
	}
}
