<?php
/**
 * Vira module: 01-smart-search
 * @package Vira
 */
namespace Vira\Modules\Smart_Search;

if ( ! defined( "ABSPATH" ) ) {
	exit;
}

class Controller {
	public static function init() {
		// جستجوی ایجکس

		add_action( "wp_ajax_vira_smart_search", array( __CLASS__, "search" ) );
		add_action( "wp_ajax_nopriv_vira_smart_search", array( __CLASS__, "search" ) );
	}
	public static function search() {
		check_ajax_referer( "vira_ajax_nonce", "security" );
		$q = isset($_GET["q"]) ? sanitize_text_field( wp_unslash( $_GET["q"] ) ) : "";
		if ( strlen( $q ) < 2 ) { wp_send_json_success( array() ); }
		$query = new \WP_Query( array( "post_type"=>"product", "s"=>$q, "posts_per_page"=>8, "post_status"=>"publish" ) );
		$out = array();
		foreach ( $query->posts as $p ) {
			$prod = wc_get_product( $p->ID );
			$out[] = array( "id"=>$p->ID, "title"=>$p->post_title, "url"=>get_permalink($p), "price"=> $prod ? $prod->get_price_html() : "" );
		}
		set_transient( $cache_key, $out, 2 * MINUTE_IN_SECONDS );
		wp_send_json_success( $out );

	}
}
