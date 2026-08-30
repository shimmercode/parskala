<?php
namespace Vira\Modules\AI_Recommend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( '14-ai-recommend' ) ) {
			return;
		}
		require_once get_template_directory() . '/inc/class-vira-recommendation.php';
		add_action( 'template_redirect', array( __CLASS__, 'track' ) );
		add_action( 'woocommerce_after_single_product_summary', array( __CLASS__, 'render' ), 18 );
	}

	public static function track() {
		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}
		$id  = get_the_ID();
		$raw = isset( $_COOKIE['vira_viewed'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['vira_viewed'] ) ) : '';
		$ids = array_filter( array_map( 'absint', explode( ',', $raw ) ) );
		array_unshift( $ids, $id );
		$ids = array_slice( array_unique( $ids ), 0, 20 );
		setcookie( 'vira_viewed', implode( ',', $ids ), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
	}

	public static function render() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$engine = new \ViraRecommendationEngine();
		$ids    = $engine->recommend( $product->get_id() );
		if ( ! $ids ) {
			return;
		}
		echo '<section class="vira-ai-recommend"><h3>پیشنهاد بر اساس رفتار خرید</h3><ul class="products vira-products-grid">';
		foreach ( $ids as $id ) {
			$GLOBALS['post'] = get_post( $id );
			setup_postdata( $GLOBALS['post'] );
			wc_get_template_part( 'content', 'product' );
		}
		echo '</ul></section>';
		wp_reset_postdata();
	}
}
