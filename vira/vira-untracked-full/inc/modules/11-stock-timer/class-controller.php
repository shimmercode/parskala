<?php
/**
 * Sale countdown timer.
 *
 * @package Vira
 */

namespace Vira\Modules\Stock_Timer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'render' ), 15 );
		add_action( 'woocommerce_before_shop_loop_item_title', array( __CLASS__, 'loop_stock' ), 20 );
	}

	public static function render() {
		global $product;
		if ( ! $product || ! $product->is_on_sale() ) {
			return;
		}
		$to = $product->get_date_on_sale_to();
		$end = $to ? $to->getTimestamp() : ( time() + DAY_IN_SECONDS );
		$qty = $product->get_stock_quantity();
		?>
		<div class="vira-stock-timer" data-end="<?php echo esc_attr( $end ); ?>">
			<div class="timer-label">پیشنهاد شگفت‌انگیز</div>
			<div class="timer-digits">
				<span class="t-h">۰۰</span>:<span class="t-m">۰۰</span>:<span class="t-s">۰۰</span>
			</div>
			<?php if ( null !== $qty ) : ?>
				<div class="stock-left">موجودی باقی‌مانده: <?php echo esc_html( $qty ); ?></div>
			<?php endif; ?>
		</div>
		<?php
	}

	public static function loop_stock() {
		global $product;
		if ( $product && $product->managing_stock() && $product->get_stock_quantity() !== null && $product->get_stock_quantity() <= 5 && $product->get_stock_quantity() > 0 ) {
			echo '<div class="vira-low-stock">تنها ' . esc_html( $product->get_stock_quantity() ) . ' عدد</div>';
		}
	}
}
