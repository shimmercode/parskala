<?php
/**
 * Related recommendations from viewed + category.
 *
 * @package Vira
 */

namespace Vira\Modules\AI_Recommend;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
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
		$ids = array_slice( array_unique( $ids ), 0, 12 );
		setcookie( 'vira_viewed', implode( ',', $ids ), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
	}

	public static function render() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$cats = wc_get_product_term_ids( $product->get_id(), 'product_cat' );
		$q    = new \WP_Query(
			array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => 4,
				'post__not_in'   => array( $product->get_id() ),
				'tax_query'      => $cats ? array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => $cats,
					),
				) : array(),
			)
		);
		if ( ! $q->have_posts() ) {
			return;
		}
		echo '<section class="vira-ai-recommend"><h3>پیشنهاد بر اساس بازدید شما</h3><ul class="products vira-products-grid">';
		while ( $q->have_posts() ) {
			$q->the_post();
			wc_get_template_part( 'content', 'product' );
		}
		echo '</ul></section>';
		wp_reset_postdata();
	}
}
