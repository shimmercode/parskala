<?php
/**
 * Vira module: 09-vendor-shield
 * @package Vira
 */
namespace Vira\Modules\Vendor_Shield;

if ( ! defined( "ABSPATH" ) ) {
	exit;
}

class Controller {
	public static function init() {
		// فروشنده فروشگاه (بدون دکان)

		add_action( "woocommerce_single_product_summary", array( __CLASS__, "badge" ), 8 );
	}
	public static function badge() {
		echo "<div class=\"vira-vendor-shield\" style=\"margin:8px 0;font-size:13px;color:#00a651;\">فروشنده: فروشگاه ویرا — ضمانت اصالت کالا</div>";

	}
}
