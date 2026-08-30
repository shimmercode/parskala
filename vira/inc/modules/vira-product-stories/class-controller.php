<?php
/**
 * Shop stories from sale products + optional CPT.
 *
 * @package Vira
 */

namespace Vira\Modules\Product_Stories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		add_action( 'init', array( __CLASS__, 'cpt' ) );
		add_action( 'vira_home_stories', array( __CLASS__, 'render' ) );
	}

	public static function cpt() {
		register_post_type(
			'vira_story',
			array(
				'labels'       => array(
					'name'          => 'استوری ویرا',
					'singular_name' => 'استوری',
				),
				'public'       => false,
				'show_ui'      => true,
				'supports'     => array( 'title', 'thumbnail', 'custom-fields' ),
				'menu_icon'    => 'dashicons-format-image',
			)
		);
	}

	public static function maybe_home( $q ) {
		if ( is_admin() || ! $q->is_main_query() ) {
			return;
		}
		if ( is_front_page() || is_home() ) {
			self::render();
		}
	}

	public static function render() {
		static $done = false;
		if ( $done ) {
			return;
		}
		$done = true;
		$stories = get_posts( array( 'post_type' => 'vira_story', 'numberposts' => 8, 'post_status' => 'publish' ) );
		if ( ! $stories && function_exists( 'wc_get_products' ) ) {
			$products = wc_get_products( array( 'limit' => 8, 'status' => 'publish', 'orderby' => 'date' ) );
			echo '<section class="vira-stories-section vira-real-stories"><div class="vira-container"><h2>استوری‌های فروشگاه</h2><div class="vira-stories-circles">';
			foreach ( $products as $p ) {
				echo '<a class="story-circle-item" href="' . esc_url( $p->get_permalink() ) . '">';
				echo $p->get_image( 'thumbnail', array( 'style' => 'width:68px;height:68px;border-radius:50%;object-fit:cover;' ) ); // phpcs:ignore
				echo '<span>' . esc_html( wp_trim_words( $p->get_name(), 4 ) ) . '</span></a>';
			}
			echo '</div></div></section>';
			return;
		}
		if ( ! $stories ) {
			return;
		}
		echo '<section class="vira-stories-section vira-real-stories"><div class="vira-container"><h2>استوری‌های فروشگاه</h2><div class="vira-stories-circles">';
		foreach ( $stories as $s ) {
			$link = get_post_meta( $s->ID, '_vira_story_url', true );
			echo '<a class="story-circle-item" href="' . esc_url( $link ? $link : '#' ) . '">';
			echo get_the_post_thumbnail( $s->ID, 'thumbnail', array( 'style' => 'width:68px;height:68px;border-radius:50%;object-fit:cover;' ) );
			echo '<span>' . esc_html( $s->post_title ) . '</span></a>';
		}
		echo '</div></div></section>';
	}
}
