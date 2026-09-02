<?php
namespace Vira\Modules\Vendor_Shield;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'badge' ), 8 );
	}

	public static function badge() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$count  = (int) $product->get_review_count();
		$avg    = (float) $product->get_average_rating();
		$store  = get_bloginfo( 'name' );
		echo '<div class="vira-vendor-shield">';
		echo '<strong>فروشنده: ' . esc_html( $store ) . '</strong>';
		if ( $count ) {
			echo ' <span class="score">رضایت ' . esc_html( number_format_i18n( $avg, 1 ) ) . ' از ۵ (' . (int) $count . ' نظر)</span>';
		} else {
			echo ' <span class="score">هنوز نظری ثبت نشده</span>';
		}
		echo '</div>';
	}
}
