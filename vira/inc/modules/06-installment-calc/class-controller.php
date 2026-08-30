<?php
namespace Vira\Modules\Installment_Calc;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface ViraInstallmentProviderInterface {
	public function is_available();
	public function create_payment( $order_id );
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( '06-installment-calc' ) ) {
			return;
		}
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'box' ), 25 );
	}

	public static function box() {
		$configured = (bool) get_option( 'vira_installment_api_key', '' );
		echo '<div class="vira-installment-box">';
		echo '<h4>خرید اقساطی</h4>';
		if ( ! $configured ) {
			echo '<p>Provider not configured</p>';
		} else {
			echo '<p>درگاه اقساط پیکربندی شده است. تکمیل پرداخت پس از ثبت سفارش انجام می‌شود.</p>';
		}
		echo '</div>';
	}
}
