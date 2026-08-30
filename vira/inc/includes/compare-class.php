<?php
defined( 'ABSPATH' ) || exit;
function prk_is_product( $product ) {

	if ( $product && 'product' === get_post_type( $product->get_id() ) ) {
		return true;
	}

	return false;
}



class prk_Products_Compare_Frontend {
	private static $_this;
	public static $cookie_name;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public function __construct() {
		self::$_this = $this;

		// Set the cookie name.
		self::$cookie_name = 'wc_products_compare_products';



		return true;
	}


	public function get_instance() {
		return self::$_this;
	}


	public static function get_endpoint() {

		// set the endpoint per user setting
		return 'prk-compare';
	}


	public static function get_page_title() {
		return __( 'مقایسه محصولات', 'parskala' );
	}


	public function is_compare_page() {
		global $wp_query;

		return array_key_exists( $this->get_endpoint(), $wp_query->query_vars );
	}




	/**
	 * Add compare page endpoint to permalink structure.
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public function add_endpoint() {
		add_rewrite_endpoint( $this->get_endpoint(), EP_ROOT );

		// Only flush once on activate when endpoint is not yet set.
		if ( ! get_option( 'wc_products_compare_endpoint_set', false ) ) {
			flush_rewrite_rules();

			// update option so this doesn't need to run again
			update_option( 'wc_products_compare_endpoint_set', true );
		}

		return true;
	}

	/**
	 * Return the page title for compare page.
	 *
	 * @since 1.0.5
	 * @return string $title
	 */
	public function add_page_title( $title ) {
		if ( $this->is_compare_page() ) {
			$title = $this->get_page_title();
		}

		return $title;
	}

	/**
	 * Add a breadcrumb for the compare page.
	 *
	 * @since 1.0.5
	 * @return array $crumbs
	 */
	public function add_wc_breadcrumb( $crumbs) {
		if ( $this->is_compare_page() ) {
			$crumbs[1] = array( $this->get_page_title() );
		}

		return $crumbs;
	}

	/**
	 * Display the compare page template.
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public function display_template( $path ) {
		if ( $this->is_compare_page() ) {

			//include(parskala_TEMPLATEPATH.'/includes/compare-page-html.php');
			exit;
		}

		return $path;
	}



	/**
	 * Checks if the product is listed in the compared products cookie.
	 *
	 * @since 1.0.0
	 * @param $product_id int
	 * @return bool
	 */
	public function is_listed( $product_id ) {
		$products = $this->get_compared_products(); // Comma delimited string.

		// List exists.
		if ( $products && is_array( $products ) && in_array( (string) $product_id, $products ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get the selected compared products from cookie.
	 *
	 * @since 1.0.0
	 * @return $ids array
	 */
	public static function get_compared_products() {
		$products = isset( $_GET[ 'products' ] ) ? $_GET[ 'products' ] : false;

		// Check if list exists.
		if ( ! empty( $products ) ) {
			// Convert it back to array.
			$products = explode( ',', $products );
		} else {
			$products = false;
		}

		return $products;
	}

	/**
	 * Get product metas headers.
	 *
	 * @since 1.0.0
	 * @param array $products
	 * @return array $headers
	 */
	public static function get_product_meta_headers( $products = array() ) {
		if ( empty( $products ) ) {
			return 0;
		}

		$headers = array();

		foreach ( $products as $product ) {

			$product = wc_get_product( $product );

			if ( ! prk_is_product( $product ) ) {
				continue;
			}

			$attributes = $product->get_attributes();



			if ( $product->get_sku() ) {
				$headers[] = 'sku';
			}

			if ( $product->managing_stock() ) {
				$headers[] = 'stock';
			}

			if ( is_array( $attributes ) && ! empty( $attributes ) ) {
				foreach ( $attributes as $attribute => $value ) {
					if ( ! in_array( $attribute, $headers, true ) && $value['is_visible'] ) {
						$headers[] = $value->get_name();
					}
				}
			}
		}

		// Remove any duplicates.
		$headers = array_unique( $headers );

		// Move description to the top.
		if ( in_array( 'description', $headers, true ) ) {
			// Get array key index position.
			$index = array_search( 'description', $headers );

			unset( $headers[ $index ] );

			array_unshift( $headers, 'description' );
		}

		// Move sku to the top.
		if ( in_array( 'sku', $headers, true ) ) {
			// Get array key index position.
			$index = array_search( 'sku', $headers );

			unset( $headers[ $index ] );

			array_unshift( $headers, 'sku' );
		}

		// Move stock to the top.
		if ( in_array( 'stock', $headers, true ) ) {
			// Get array key index position.
			$index = array_search( 'stock', $headers );

			unset( $headers[ $index ] );

			array_unshift( $headers, 'stock' );
		}

		return $headers;
	}




}

new prk_Products_Compare_Frontend();
