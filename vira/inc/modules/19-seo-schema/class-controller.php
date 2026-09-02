<?php
namespace Vira\Modules\SEO_Schema;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'wp_head', array( __CLASS__, 'schema' ) );
	}

	public static function schema() {
		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}
		global $product;
		if ( ! $product ) {
			return;
		}
		$data = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'Product',
			'name'        => $product->get_name(),
			'sku'         => $product->get_sku(),
			'description' => wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() ),
			'url'         => get_permalink( $product->get_id() ),
			'image'       => wp_get_attachment_url( $product->get_image_id() ),
			'offers'      => array(
				'@type'         => 'Offer',
				'price'         => $product->get_price(),
				'priceCurrency' => get_woocommerce_currency(),
				'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
			),
		);
		if ( $product->get_review_count() ) {
			$data['aggregateRating'] = array(
				'@type'       => 'AggregateRating',
				'ratingValue' => $product->get_average_rating(),
				'reviewCount' => $product->get_review_count(),
			);
		}
		echo '<script type="application/ld+json">' . wp_json_encode( $data ) . '</script>';
	}
}
