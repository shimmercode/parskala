<?php
namespace Vira\Modules\Free_Shipping;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! function_exists( 'vira_is_module_enabled' ) || ! vira_is_module_enabled( '05-free-shipping' ) ) {
			return;
		}
		add_action( 'woocommerce_widget_shopping_cart_before_buttons', array( __CLASS__, 'bar' ), 10 );
		add_action( 'woocommerce_before_cart_table', array( __CLASS__, 'bar' ), 10 );
		add_action( 'woocommerce_before_checkout_form', array( __CLASS__, 'bar' ), 5 );
		add_filter( 'woocommerce_add_to_cart_fragments', array( __CLASS__, 'fragments' ) );
	}

	public static function threshold() {
		return absint( get_option( 'vira_free_shipping_threshold', 1500000 ) );
	}

	public static function html() {
		if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
			return '';
		}
		$threshold = self::threshold();
		if ( $threshold <= 0 ) {
			return '';
		}
		$subtotal = (float) WC()->cart->get_subtotal();
		$percent  = min( 100, (int) ( ( $subtotal / $threshold ) * 100 ) );
		$remain   = max( 0, $threshold - $subtotal );
		ob_start();
		echo '<div class="vira-free-shipping-progress" id="vira-free-shipping-progress">';
		if ( $remain > 0 ) {
			echo '<div class="progress-label"><span>برای ارسال رایگان ' . wp_kses_post( vira_format_toman( $remain ) ) . ' دیگر خرید کنید.</span></div>';
		} else {
			echo '<div class="progress-label success"><span>سفارش شما مشمول ارسال رایگان شد.</span></div>';
		}
		echo '<div class="progress-bar-track"><div class="progress-bar-fill" style="width:' . esc_attr( $percent ) . '%"></div></div></div>';
		return ob_get_clean();
	}

	public static function bar() {
		echo self::html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public static function fragments( $fragments ) {
		$fragments['#vira-free-shipping-progress'] = self::html();
		return $fragments;
	}
}
