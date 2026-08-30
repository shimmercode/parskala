<?php
/**
 * Complementary bundle with discount.
 *
 * @package Vira
 */

namespace Vira\Modules\Bundle_Discount;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'woocommerce_after_single_product_summary', array( __CLASS__, 'render' ), 12 );
		add_action( 'wp_ajax_vira_add_bundle', array( __CLASS__, 'add_bundle' ) );
		add_action( 'wp_ajax_nopriv_vira_add_bundle', array( __CLASS__, 'add_bundle' ) );
	}

	public static function render() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$related = wc_get_related_products( $product->get_id(), 3 );
		if ( ! $related ) {
			return;
		}
		$ids = array_merge( array( $product->get_id() ), $related );
		?>
		<section class="vira-bundle-box">
			<h3>با هم بخرید — ۱۰٪ تخفیف پکیج</h3>
			<ul class="vira-bundle-list">
				<?php foreach ( $ids as $id ) : $p = wc_get_product( $id ); if ( ! $p ) { continue; } ?>
					<li>
						<?php echo $p->get_image( 'woocommerce_gallery_thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><?php echo esc_html( $p->get_name() ); ?></span>
						<span><?php echo wp_kses_post( $p->get_price_html() ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
			<button type="button" class="button vira-add-bundle" data-ids="<?php echo esc_attr( implode( ',', $ids ) ); ?>">افزودن پکیج به سبد</button>
		</section>
		<?php
	}

	public static function add_bundle() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
			wp_send_json_error( array( 'message' => 'سبد در دسترس نیست.' ) );
		}
		$ids = isset( $_POST['ids'] ) ? array_filter( array_map( 'absint', explode( ',', sanitize_text_field( wp_unslash( $_POST['ids'] ) ) ) ) ) : array();
		foreach ( $ids as $id ) {
			WC()->cart->add_to_cart( $id, 1 );
		}
		wp_send_json_success( array( 'redirect' => wc_get_cart_url() ) );
	}
}
