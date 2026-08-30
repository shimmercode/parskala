<?php
/**
 * Installment calculator UI.
 *
 * @package Vira
 */

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
		?>
		<div class="vira-installment-box" data-price="<?php echo esc_attr( $price ); ?>">
			<h4>خرید اقساطی</h4>
			<ul>
				<li>اسنپ‌پی ۴ قسط: <strong class="snapp">—</strong></li>
				<li>تارا ۶ قسط: <strong class="tara">—</strong></li>
				<li>دیجی‌پی ۱۲ قسط: <strong class="digi">—</strong></li>
			</ul>
		</div>
		<?php
	}
}
