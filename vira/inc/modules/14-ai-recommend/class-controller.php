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
		if ( is_user_logged_in() ) {
			update_user_meta( get_current_user_id(), '_vira_viewed', $ids );
		}
	}

	public static function score_ids( $exclude ) {
		$scores = array();
		$viewed = array();
		if ( isset( $_COOKIE['vira_viewed'] ) ) {
			$viewed = array_filter( array_map( 'absint', explode( ',', sanitize_text_field( wp_unslash( $_COOKIE['vira_viewed'] ) ) ) ) );
		}
		$cats = array();
		$brands = array();
		foreach ( $viewed as $vid ) {
			$cats   = array_merge( $cats, wc_get_product_term_ids( $vid, 'product_cat' ) );
			$brands = array_merge( $brands, wc_get_product_term_ids( $vid, 'product_brand' ) );
		}
		$cart_ids = array();
		if ( function_exists( 'WC' ) && WC()->cart ) {
			foreach ( WC()->cart->get_cart() as $item ) {
				$cart_ids[] = (int) $item['product_id'];
				$cats       = array_merge( $cats, wc_get_product_term_ids( $item['product_id'], 'product_cat' ) );
			}
		}
		$q = new \WP_Query(
			array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => 24,
				'post__not_in'   => array_filter( array_merge( array( $exclude ), $viewed ) ),
				'fields'         => 'ids',
			)
		);
		foreach ( $q->posts as $pid ) {
			$s = 0;
			$pc = wc_get_product_term_ids( $pid, 'product_cat' );
			$s += count( array_intersect( $cats, $pc ) ) * 5;
			$pb = wc_get_product_term_ids( $pid, 'product_brand' );
			$s += count( array_intersect( $brands, $pb ) ) * 3;
			if ( in_array( (int) $pid, $cart_ids, true ) ) {
				$s += 2;
			}
			$prod = wc_get_product( $pid );
			if ( $prod && $prod->is_on_sale() ) {
				$s += 1;
			}
			$scores[ $pid ] = $s;
		}
		arsort( $scores );
		return array_slice( array_keys( $scores ), 0, 4 );
	}

	public static function render() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$ids = self::score_ids( $product->get_id() );
		if ( ! $ids ) {
			return;
		}
		echo '<section class="vira-ai-recommend"><h3>پیشنهاد بر اساس رفتار شما</h3><ul class="products vira-products-grid">';
		foreach ( $ids as $id ) {
			$GLOBALS['post'] = get_post( $id );
			setup_postdata( $GLOBALS['post'] );
			wc_get_template_part( 'content', 'product' );
		}
		echo '</ul></section>';
		wp_reset_postdata();
	}
}
