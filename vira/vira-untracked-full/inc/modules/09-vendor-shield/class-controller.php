<?php
namespace Vira\Modules\Vendor_Shield;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( '09-vendor-shield' ) ) {
			return;
		}
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'badge' ), 8 );
	}

	public static function badge() {
		$store = get_bloginfo( 'name' );
		$score = absint( get_option( 'vira_store_trust_score', 0 ) );
		$ver   = (bool) get_option( 'vira_store_verified', false );
		echo '<div class="vira-vendor-shield">';
		echo '<strong>فروشنده: ' . esc_html( $store ) . '</strong>';
		if ( $ver ) {
			echo ' <span class="verified">تأییدشده توسط ویرا</span>';
		}
		if ( $score > 0 ) {
			echo ' <span class="score">امتیاز اعتماد: ' . esc_html( $score ) . '</span>';
		}
		echo '</div>';
	}
}
