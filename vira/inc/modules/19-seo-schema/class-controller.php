<?php
/**
 * Vira module: 19-seo-schema
 * @package Vira
 */
namespace Vira\Modules\SEO_Schema;

if ( ! defined( "ABSPATH" ) ) {
	exit;
}

class Controller {
	public static function init() {
		// اسکیما محصول

		add_action( "wp_head", array( __CLASS__, "schema" ) );
	}
	public static function schema() {
		if ( ! function_exists("is_product") || ! is_product() ) { return; }
		global $product;
		if ( ! $product ) { return; }
		$data = array(
			"@context"=>"https://schema.org",
			"@type"=>"Product",
			"name"=>$product->get_name(),
			"sku"=>$product->get_sku(),
			"offers"=>array("@type"=>"Offer","price"=>$product->get_price(),"priceCurrency"=>"IRR"),
		);
		echo "<script type=\"application/ld+json\">" . wp_json_encode( $data ) . "</script>";

	}
}
