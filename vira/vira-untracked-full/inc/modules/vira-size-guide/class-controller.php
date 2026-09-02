<?php
/**
 * Size guide modal from product meta.
 *
 * @package Vira
 */

namespace Vira\Modules\Size_Guide;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'metabox' ) );
		add_action( 'save_post_product', array( __CLASS__, 'save' ) );
		add_action( 'woocommerce_before_add_to_cart_form', array( __CLASS__, 'button' ) );
		add_action( 'wp_footer', array( __CLASS__, 'modal' ) );
	}

	public static function metabox() {
		add_meta_box( 'vira_size_guide', 'راهنمای سایز ویرا', array( __CLASS__, 'box' ), 'product', 'normal' );
	}

	public static function box( $post ) {
		wp_nonce_field( 'vira_size_guide', 'vira_size_guide_nonce' );
		$val = get_post_meta( $post->ID, '_vira_size_guide', true );
		echo '<textarea name="vira_size_guide" rows="8" style="width:100%">' . esc_textarea( $val ) . '</textarea>';
		echo '<p>جدول سایز را به صورت متن یا HTML ساده وارد کنید.</p>';
	}

	public static function save( $post_id ) {
		if ( ! isset( $_POST['vira_size_guide_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vira_size_guide_nonce'] ) ), 'vira_size_guide' ) ) {
			return;
		}
		if ( isset( $_POST['vira_size_guide'] ) ) {
			update_post_meta( $post_id, '_vira_size_guide', wp_kses_post( wp_unslash( $_POST['vira_size_guide'] ) ) );
		}
	}

	public static function button() {
		global $product;
		if ( ! $product ) {
			return;
		}
		$guide = get_post_meta( $product->get_id(), '_vira_size_guide', true );
		if ( ! $guide ) {
			return;
		}
		echo '<p><button type="button" class="vira-size-guide-open">راهنمای سایز</button></p>';
	}

	public static function modal() {
		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}
		$guide = get_post_meta( get_the_ID(), '_vira_size_guide', true );
		if ( ! $guide ) {
			return;
		}
		echo '<div id="vira-size-guide-modal" class="vira-modal-overlay"><div class="vira-modal-box"><div class="vira-modal-header"><h3>راهنمای سایز</h3><button type="button" class="vira-modal-close">&times;</button></div><div class="vira-modal-body">';
		echo wp_kses_post( wpautop( $guide ) );
		echo '</div></div></div>';
	}
}
