<?php
/**
 * Live product search.
 *
 * @package Vira
 */

namespace Vira\Modules\Smart_Search;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'wp_ajax_vira_smart_search', array( __CLASS__, 'search' ) );
		add_action( 'wp_ajax_nopriv_vira_smart_search', array( __CLASS__, 'search' ) );
	}

	public static function search() {
		check_ajax_referer( 'vira_ajax_nonce', 'security' );
		$q = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
		if ( strlen( $q ) < 2 ) {
			wp_send_json_success( array() );
		}
		$cache_key = 'vira_s_' . md5( $q );
		$cached    = get_transient( $cache_key );
		if ( is_array( $cached ) ) {
			wp_send_json_success( $cached );
		}
		$query = new \WP_Query(
			array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				's'              => $q,
				'posts_per_page' => 8,
			)
		);
		$out = array();
		foreach ( $query->posts as $p ) {
			$prod = wc_get_product( $p->ID );
			$out[] = array(
				'id'    => $p->ID,
				'title' => $p->post_title,
				'url'   => get_permalink( $p ),
				'price' => $prod ? $prod->get_price_html() : '',
			);
		}
		set_transient( $cache_key, $out, 2 * MINUTE_IN_SECONDS );
		wp_send_json_success( $out );
	}
}
