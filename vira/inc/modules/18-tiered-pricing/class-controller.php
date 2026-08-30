<?php
namespace Vira\Modules\Tiered_Pricing;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( '18-tiered-pricing' ) ) {
			return;
		}
		add_action( 'add_meta_boxes', array( __CLASS__, 'box' ) );
		add_action( 'save_post_product', array( __CLASS__, 'save' ) );
		add_action( 'product_cat_edit_form_fields', array( __CLASS__, 'cat_field' ) );
		add_action( 'edited_product_cat', array( __CLASS__, 'save_cat' ) );
		add_filter( 'woocommerce_product_get_price', array( __CLASS__, 'price' ), 20, 2 );
		add_filter( 'woocommerce_product_variation_get_price', array( __CLASS__, 'price' ), 20, 2 );
	}

	public static function box() {
		add_meta_box( 'vira_b2b', 'قیمت پلکانی محصول', array( __CLASS__, 'render_box' ), 'product', 'normal' );
	}

	public static function render_box( $post ) {
		wp_nonce_field( 'vira_b2b', 'vira_b2b_nonce' );
		$rows = get_post_meta( $post->ID, '_vira_b2b_tiers', true );
		if ( ! is_array( $rows ) ) {
			$rows = array( array( 'min' => 1, 'max' => 4, 'value' => 0 ) );
		}
		foreach ( $rows as $i => $r ) {
			echo '<p><input name="vira_b2b[' . esc_attr( $i ) . '][min]" type="number" value="' . esc_attr( $r['min'] ) . '" style="width:70px">';
			echo '<input name="vira_b2b[' . esc_attr( $i ) . '][max]" type="number" value="' . esc_attr( $r['max'] ) . '" style="width:70px">';
			echo '<input name="vira_b2b[' . esc_attr( $i ) . '][value]" type="number" value="' . esc_attr( $r['value'] ) . '" style="width:70px"> %</p>';
		}
	}

	public static function save( $post_id ) {
		if ( ! isset( $_POST['vira_b2b_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vira_b2b_nonce'] ) ), 'vira_b2b' ) ) {
			return;
		}
		if ( empty( $_POST['vira_b2b'] ) || ! is_array( $_POST['vira_b2b'] ) ) {
			return;
		}
		$out = array();
		foreach ( $_POST['vira_b2b'] as $row ) {
			$out[] = array(
				'min'   => absint( $row['min'] ),
				'max'   => absint( $row['max'] ),
				'value' => absint( $row['value'] ),
			);
		}
		update_post_meta( $post_id, '_vira_b2b_tiers', $out );
	}

	public static function cat_field( $term ) {
		$v = get_term_meta( $term->term_id, '_vira_b2b_percent', true );
		echo '<tr class="form-field"><th>تخفیف پلکانی دسته %</th><td><input name="vira_b2b_percent" type="number" value="' . esc_attr( $v ) . '"></td></tr>';
	}

	public static function save_cat( $term_id ) {
		if ( isset( $_POST['vira_b2b_percent'] ) ) {
			update_term_meta( $term_id, '_vira_b2b_percent', absint( $_POST['vira_b2b_percent'] ) );
		}
	}

	public static function qty_for( $product ) {
		$qty = 1;
		if ( function_exists( 'WC' ) && WC()->cart ) {
			foreach ( WC()->cart->get_cart() as $item ) {
				if ( (int) $item['product_id'] === (int) $product->get_id() ) {
					$qty = (int) $item['quantity'];
				}
			}
		}
		return $qty;
	}

	public static function apply_tiers( $price, $tiers, $qty ) {
		if ( ! is_array( $tiers ) ) {
			return $price;
		}
		foreach ( $tiers as $t ) {
			$min = (int) $t['min'];
			$max = (int) $t['max'];
			if ( $qty >= $min && ( 0 === $max || $qty <= $max ) ) {
				$pct = (int) $t['value'];
				if ( $pct > 0 && $pct < 100 ) {
					return (float) $price * ( 1 - ( $pct / 100 ) );
				}
			}
		}
		return $price;
	}

	public static function price( $price, $product ) {
		if ( ( is_admin() && ! wp_doing_ajax() ) || ! $product || $price === '' ) {
			return $price;
		}
		$qty   = self::qty_for( $product );
		$tiers = get_post_meta( $product->get_id(), '_vira_b2b_tiers', true );
		if ( is_array( $tiers ) && ! empty( $tiers ) ) {
			return self::apply_tiers( $price, $tiers, $qty );
		}
		$cats = wc_get_product_term_ids( $product->get_id(), 'product_cat' );
		foreach ( $cats as $cid ) {
			$pct = (int) get_term_meta( $cid, '_vira_b2b_percent', true );
			if ( $pct > 0 && $qty >= 5 ) {
				return (float) $price * ( 1 - ( $pct / 100 ) );
			}
		}
		$global = (int) get_option( 'vira_b2b_global_percent', 0 );
		if ( $global > 0 && $qty >= 10 ) {
			return (float) $price * ( 1 - ( $global / 100 ) );
		}
		return $price;
	}
}
