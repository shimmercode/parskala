<?php
/**
 * Deterministic recommendation engine (not an external AI API).
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface ViraRecommendationProviderInterface {
	/**
	 * @param int $exclude_id
	 * @return int[]
	 */
	public function recommend( $exclude_id );
}

class ViraRecommendationEngine implements ViraRecommendationProviderInterface {
	public function recommend( $exclude_id ) {
		$scores  = array();
		$viewed  = array();
		if ( isset( $_COOKIE['vira_viewed'] ) ) {
			$viewed = array_filter( array_map( 'absint', explode( ',', sanitize_text_field( wp_unslash( $_COOKIE['vira_viewed'] ) ) ) ) );
		}
		$cats = array();
		$brands = array();
		$prices = array();
		foreach ( $viewed as $vid ) {
			$cats    = array_merge( $cats, wc_get_product_term_ids( $vid, 'product_cat' ) );
			$brands  = array_merge( $brands, wc_get_product_term_ids( $vid, 'product_brand' ) );
			$p       = wc_get_product( $vid );
			if ( $p ) {
				$prices[] = (float) $p->get_price();
			}
		}
		$cart_ids = array();
		if ( function_exists( 'WC' ) && WC()->cart ) {
			foreach ( WC()->cart->get_cart() as $item ) {
				$cart_ids[] = (int) $item['product_id'];
				$cats       = array_merge( $cats, wc_get_product_term_ids( $item['product_id'], 'product_cat' ) );
			}
		}
		$avg_price = $prices ? array_sum( $prices ) / count( $prices ) : 0;
		$q         = new WP_Query(
			array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => 30,
				'post__not_in'   => array_filter( array_merge( array( $exclude_id ), $viewed ) ),
				'fields'         => 'ids',
			)
		);
		foreach ( $q->posts as $pid ) {
			$s  = 0;
			$pc = wc_get_product_term_ids( $pid, 'product_cat' );
			$s += count( array_intersect( $cats, $pc ) ) * 5;
			$pb = wc_get_product_term_ids( $pid, 'product_brand' );
			$s += count( array_intersect( $brands, $pb ) ) * 3;
			$prod = wc_get_product( $pid );
			if ( $prod && $avg_price > 0 ) {
				$diff = abs( (float) $prod->get_price() - $avg_price );
				if ( $diff < $avg_price * 0.25 ) {
					$s += 2;
				}
			}
			if ( $prod && $prod->is_on_sale() ) {
				$s += 1;
			}
			$scores[ $pid ] = $s;
		}
		arsort( $scores );
		return array_slice( array_keys( $scores ), 0, 4 );
	}
}
