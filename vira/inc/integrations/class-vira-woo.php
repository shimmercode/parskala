<?php
/**
 * WooCommerce core only (module UI lives in modules).
 *
 * @package Vira
 */

namespace Vira\Integrations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Woo_Integration {
	private static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}
		add_filter( 'wc_price', array( $this, 'format_persian_wc_price' ), 100, 4 );
	}

	public function format_persian_wc_price( $return, $price, $args, $unformatted_price ) {
		if ( is_admin() && ! wp_doing_ajax() ) {
			return $return;
		}
		if ( ! function_exists( 'vira_format_toman' ) ) {
			return $return;
		}
		return '<span class="woocommerce-Price-amount amount">' . vira_format_toman( $price, true ) . '</span>';
	}
}

Woo_Integration::get_instance();
