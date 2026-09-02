<?php
/**
 * Elementor widgets: amazing rail + chips.
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vira_Elementor_Amazing extends \Elementor\Widget_Base {
	public function get_name() {
		return 'vira_amazing';
	}
	public function get_title() {
		return 'ویرا شگفت‌انگیز';
	}
	public function get_icon() {
		return 'eicon-products';
	}
	public function get_categories() {
		return array( 'general' );
	}
	protected function render() {
		if ( ! class_exists( 'Vira_Digikala_Layer' ) ) {
			return;
		}
		$items = class_exists( 'Vira_Pro' ) ? Vira_Pro::amazing_products() : array();
		echo '<div class="dk-rail">';
		foreach ( $items as $p ) {
			echo Vira_Digikala_Layer::card( $p ); // phpcs:ignore
		}
		echo '</div>';
	}
}

class Vira_Elementor_Chips extends \Elementor\Widget_Base {
	public function get_name() {
		return 'vira_chips';
	}
	public function get_title() {
		return 'ویرا چیپ سرویس';
	}
	public function get_icon() {
		return 'eicon-button';
	}
	public function get_categories() {
		return array( 'general' );
	}
	protected function render() {
		$shop = class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
		$chips = array( 'سوپرمارکت', 'جت', 'استایل', 'الکترونیک', 'خانه', 'موبایل' );
		echo '<div class="dk-chips">';
		foreach ( $chips as $c ) {
			echo '<a href="' . esc_url( $shop ) . '">' . esc_html( $c ) . '</a>';
		}
		echo '</div>';
	}
}
