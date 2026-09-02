<?php
namespace Vira\Modules\Installment_Calc;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( '06-installment-calc' ) ) {
			return;
		}
		require_once get_template_directory() . '/inc/installments/class-vira-installments.php';
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'box' ), 25 );
	}

	public static function box() {
		$p = \Vira_Installments::current();
		echo '<div class="vira-installment-box"><h4>خرید اقساطی</h4>';
		if ( ! $p || ! $p->is_available() ) {
			echo '<p>Provider not configured</p></div>';
			return;
		}
		echo '<p>درگاه فعال: ' . esc_html( $p->get_id() ) . '</p></div>';
	}
}
