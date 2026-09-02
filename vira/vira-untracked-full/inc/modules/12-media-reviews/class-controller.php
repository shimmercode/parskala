<?php
/**
 * Photo reviews.
 *
 * @package Vira
 */

namespace Vira\Modules\Media_Reviews;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'comment_form_logged_in_after', array( __CLASS__, 'field' ) );
		add_action( 'comment_form_after_fields', array( __CLASS__, 'field' ) );
		add_action( 'comment_post', array( __CLASS__, 'save' ), 10, 3 );
		add_filter( 'comment_text', array( __CLASS__, 'show' ), 20, 2 );
		add_action( 'woocommerce_after_single_product_summary', array( __CLASS__, 'gallery' ), 8 );
	}

	public static function enctype( $defaults ) {
		$defaults['class_form'] = trim( ( $defaults['class_form'] ?? 'comment-form' ) . ' vira-has-upload' );
		return $defaults;
	}

	public static function field() {
		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}
		echo '<p class="vira-review-photo"><label>عکس نظر<input type="file" name="vira_review_image" accept="image/*"></label></p>';
		echo '<input type="hidden" name="vira_review_nonce" value="' . esc_attr( wp_create_nonce( 'vira_review_img' ) ) . '">';
	}

	public static function save( $comment_id, $approved, $data ) {
		if ( empty( $_FILES['vira_review_image']['name'] ) ) {
			return;
		}
		if ( ! isset( $_POST['vira_review_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vira_review_nonce'] ) ), 'vira_review_img' ) ) {
			return;
		}
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		$upload = wp_handle_upload( $_FILES['vira_review_image'], array( 'test_form' => false ) );
		if ( ! empty( $upload['url'] ) ) {
			add_comment_meta( $comment_id, '_vira_review_image', esc_url_raw( $upload['url'] ) );
		}
	}

	public static function show( $text, $comment ) {
		if ( ! $comment ) {
			return $text;
		}
		$url = get_comment_meta( $comment->comment_ID, '_vira_review_image', true );
		if ( $url ) {
			$text .= '<p class="vira-review-img"><img src="' . esc_url( $url ) . '" alt="" style="max-width:180px;border-radius:8px;"></p>';
		}
		return $text;
	}

	public static function gallery() {
		if ( ! is_product() ) {
			return;
		}
		$comments = get_comments( array( 'post_id' => get_the_ID(), 'status' => 'approve', 'meta_key' => '_vira_review_image' ) );
		if ( ! $comments ) {
			return;
		}
		echo '<section class="vira-media-reviews"><h3>نظرات تصویری خریداران</h3><div class="vira-media-grid">';
		foreach ( $comments as $c ) {
			$url = get_comment_meta( $c->comment_ID, '_vira_review_image', true );
			if ( $url ) {
				echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener"><img src="' . esc_url( $url ) . '" alt=""></a>';
			}
		}
		echo '</div></section>';
	}
}
