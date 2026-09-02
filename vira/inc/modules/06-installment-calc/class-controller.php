<?php
namespace Vira\Modules\Installment_Calc;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'box' ), 25 );
	}

	public static function box() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$price = (float) $product->get_price();
		if ( $price <= 0 ) {
			return;
		}
		echo '<div class="vira-installment-box"><h4>خرید اقساطی</h4><ul>';
		foreach ( array( 3, 6, 12 ) as $n ) {
			$fee  = $price * 0.02 * $n;
			$each = ( $price + $fee ) / $n;
			echo '<li>' . (int) $n . ' قسط — هر قسط ' . wp_kses_post( wc_price( $each ) ) . '</li>';
		}
		echo '</ul><small>محاسبه روی قیمت فعلی کالا. پرداخت از درگاه ووکامرس انجام می‌شود.</small></div>';
	}
}
