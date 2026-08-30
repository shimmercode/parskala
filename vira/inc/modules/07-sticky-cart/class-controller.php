<?php
namespace Vira\Modules\Sticky_Cart;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( '07-sticky-cart' ) ) {
			return;
		}
		add_action( 'wp_footer', array( __CLASS__, 'render' ), 50 );
	}

	public static function render() {
		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}
		global $product;
		if ( ! $product || ! $product->is_purchasable() ) {
			return;
		}
		?>
		<div class="vira-sticky-purchase-bar" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
			<div class="sticky-product-meta">
				<?php echo $product->get_image( 'thumbnail', array( 'class' => 'sticky-thumb' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<div class="sticky-title-price">
					<span class="sticky-title"><?php echo esc_html( $product->get_name() ); ?></span>
					<span class="sticky-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
				</div>
			</div>
			<div class="sticky-actions">
				<input type="number" class="vira-sticky-qty" value="1" min="1" step="1">
				<button type="button" class="vira-sticky-add-btn button alt"><?php esc_html_e( 'افزودن به سبد', 'vira' ); ?></button>
			</div>
		</div>
		<?php
	}
}
