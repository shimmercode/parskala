<?php
namespace PRKSMSApp;
class PRKSMSAppHelper {
	public function MayBeVariable( $product ) {

		$product_id = $this->ProductId( $product );
		$product    = wc_get_product( $product_id );
		if ( $product->is_type( 'variable' ) ) {

			unset( $product_id );

			$product_ids = [];
			foreach ( (array) $this->ProductProp( $product, 'children' ) as $product_id ) {
				//$product_ids[] = wc_get_product( $product_id );
				$product_ids[] = $product_id;
			}

			return $product_ids;//array
		} else {
			return $product_id;//int
		}
	}


    public function MaybeVariableProductTitle( $product ) {

		$product_id = $this->ProductId( $product );

		if ( ! is_object( $product ) ) {
			$product = wc_get_product( $product );
		}

		$attributes = $this->ProductProp( $product, 'variation_attributes' );
		$parent_id  = $this->ProductProp( $product, 'parent_id' );

		if ( ! empty( $attributes ) && ! empty( $parent_id ) ) {

			$parent = wc_get_product( $parent_id );

			$variation_attributes = $this->ProductProp( $parent, 'variation_attributes' );

			$variable_title = [];
			foreach ( (array) $attributes as $attribute_name => $options ) {

				$attribute_name = str_ireplace( 'attribute_', '', $attribute_name );

				foreach ( (array) $variation_attributes as $key => $value ) {
					$key = str_ireplace( 'attribute_', '', $key );

					if ( sanitize_title( $key ) == sanitize_title( $attribute_name ) ) {
						$attribute_name = $key;
						break;
					}
				}

				if ( ! empty( $options ) && substr( strtolower( $attribute_name ), 0, 3 ) !== 'pa_' ) {
					$variable_title[] = $attribute_name . ':' . $options;
				}
			}

			$product_title = get_the_title( $parent_id );

			if ( ! empty( $variable_title ) ) {
				$product_title .= ' (' . implode( ' - ', $variable_title ) . ')';
			}
		} else {
			$product_title = get_the_title( $product_id );
		}

		return html_entity_decode( urldecode( $product_title ) );
	}

    public function ProductId( $product = '' ) {

		if ( empty( $product ) ) {
			$product_id = get_the_ID();
		} else if ( is_numeric( $product ) ) {
			$product_id = $product;
		} else if ( is_object( $product ) ) {
			$product_id = $this->ProductProp( $product, 'id' );
		} else {
			$product_id = false;
		}

		return $product_id;
	}

    public function ProductProp( $product, $prop ) {
		$method = 'get_' . $prop;

		return method_exists( $product, $method ) ? $product->$method() : ( ! empty( $product->{$prop} ) ? $product->{$prop} : '' );
	}


    public function IsStockManaging( $product ) {

		if ( 'yes' !== get_option( 'woocommerce_manage_stock' ) ) {
			return false;
		}

		if ( ! is_object( $product ) ) {
			$product = wc_get_product( $product );
		}

		if ( method_exists( $product, 'get_manage_stock' ) ) {
			$manage = $product->get_manage_stock();
		} elseif ( method_exists( $product, 'managing_stock' ) ) {
			$manage = $product->managing_stock();
		} else {
			$manage = true;
		}

		if ( strtolower( $manage ) == 'parent' ) {
			$manage = false;
		}

		return $manage;
	}

    public function ProductStockQty( $product ) {

		if ( ! is_object( $product ) ) {
			$product = wc_get_product( $product );
		}

		if ( method_exists( $product, 'get_stock_quantity' ) ) {
			$quantity = $product->get_stock_quantity();
		} else {
			$quantity = $this->ProductProp( $product, 'total_stock' );
		}

		if ( empty( $quantity ) ) {
			$quantity = ( (int) get_post_meta( $this->ProductId( $product ), '_stock', true ) );
		}

		return ! empty( $quantity ) ? $quantity : 0;
	}


    public function maybeBool( $value ) {

		if ( empty( $value ) ) {
			return false;
		}

		if ( is_string( $value ) ) {

			if ( in_array( $value, [ 'on', 'true', 'yes' ] ) ) {
				return true;
			}

			if ( in_array( $value, [ 'off', 'false', 'no' ] ) ) {
				return false;
			}
		}

		return $value;
	}
}