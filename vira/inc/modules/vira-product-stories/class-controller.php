<?php
namespace Vira\Modules\Product_Stories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Controller {
	public static function init() {
		if ( ! vira_is_module_enabled( 'vira-product-stories' ) ) {
			return;
		}
		add_action( 'init', array( __CLASS__, 'cpt' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'meta' ) );
		add_action( 'save_post_vira_story', array( __CLASS__, 'save' ) );
		add_action( 'vira_home_stories', array( __CLASS__, 'render' ) );
		add_action( 'wp_footer', array( __CLASS__, 'player' ) );
	}

	public static function cpt() {
		register_post_type(
			'vira_story',
			array(
				'labels'     => array( 'name' => 'استوری ویرا', 'singular_name' => 'استوری' ),
				'public'     => false,
				'show_ui'    => true,
				'supports'   => array( 'title', 'thumbnail' ),
				'menu_icon'  => 'dashicons-format-video',
			)
		);
	}

	public static function meta() {
		add_meta_box( 'vira_story_meta', 'رسانه استوری', array( __CLASS__, 'box' ), 'vira_story', 'normal' );
	}

	public static function box( $post ) {
		wp_nonce_field( 'vira_story_meta', 'vira_story_nonce' );
		$url  = get_post_meta( $post->ID, '_vira_story_media', true );
		$type = get_post_meta( $post->ID, '_vira_story_type', true );
		$dur  = get_post_meta( $post->ID, '_vira_story_duration', true );
		$cta  = get_post_meta( $post->ID, '_vira_story_cta', true );
		echo '<p>URL تصویر یا ویدیو<br><input name="vira_story_media" style="width:100%" value="' . esc_attr( $url ) . '"></p>';
		echo '<p>نوع <select name="vira_story_type"><option value="image"' . selected( $type, 'image', false ) . '>image</option><option value="video"' . selected( $type, 'video', false ) . '>video</option></select></p>';
		echo '<p>مدت ثانیه <input name="vira_story_duration" type="number" value="' . esc_attr( $dur ? $dur : 5 ) . '"></p>';
		echo '<p>CTA URL <input name="vira_story_cta" style="width:100%" value="' . esc_attr( $cta ) . '"></p>';
	}

	public static function save( $post_id ) {
		if ( ! isset( $_POST['vira_story_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['vira_story_nonce'] ) ), 'vira_story_meta' ) ) {
			return;
		}
		update_post_meta( $post_id, '_vira_story_media', esc_url_raw( wp_unslash( $_POST['vira_story_media'] ) ) );
		update_post_meta( $post_id, '_vira_story_type', sanitize_key( wp_unslash( $_POST['vira_story_type'] ) ) );
		update_post_meta( $post_id, '_vira_story_duration', absint( $_POST['vira_story_duration'] ) );
		update_post_meta( $post_id, '_vira_story_cta', esc_url_raw( wp_unslash( $_POST['vira_story_cta'] ) ) );
	}

	public static function items() {
		$posts = get_posts( array( 'post_type' => 'vira_story', 'numberposts' => 12, 'post_status' => 'publish' ) );
		$out   = array();
		foreach ( $posts as $s ) {
			$media = get_post_meta( $s->ID, '_vira_story_media', true );
			if ( ! $media && has_post_thumbnail( $s->ID ) ) {
				$media = get_the_post_thumbnail_url( $s->ID, 'large' );
			}
			$out[] = array(
				'title'    => $s->post_title,
				'media'    => $media,
				'type'     => get_post_meta( $s->ID, '_vira_story_type', true ) ? get_post_meta( $s->ID, '_vira_story_type', true ) : 'image',
				'duration' => (int) get_post_meta( $s->ID, '_vira_story_duration', true ) ? (int) get_post_meta( $s->ID, '_vira_story_duration', true ) : 5,
				'cta'      => get_post_meta( $s->ID, '_vira_story_cta', true ),
			);
		}
		if ( ! $out && function_exists( 'wc_get_products' ) ) {
			foreach ( wc_get_products( array( 'limit' => 8, 'status' => 'publish' ) ) as $p ) {
				$out[] = array(
					'title'    => $p->get_name(),
					'media'    => $p->get_image_id() ? wp_get_attachment_url( $p->get_image_id() ) : '',
					'type'     => 'image',
					'duration' => 5,
					'cta'      => $p->get_permalink(),
				);
			}
		}
		return $out;
	}

	public static function render() {
		$items = self::items();
		if ( ! $items ) {
			return;
		}
		echo '<section class="vira-stories-section"><div class="vira-container"><h2>استوری‌ها</h2><div class="vira-stories-circles">';
		foreach ( $items as $i => $it ) {
			echo '<button type="button" class="story-circle-item js-vira-story" data-index="' . esc_attr( $i ) . '">';
			if ( $it['media'] ) {
				echo '<img src="' . esc_url( $it['media'] ) . '" alt="" style="width:68px;height:68px;border-radius:50%;object-fit:cover">';
			}
			echo '<span>' . esc_html( wp_trim_words( $it['title'], 4 ) ) . '</span></button>';
		}
		echo '</div></div></section>';
		echo '<script>window.viraStories=' . wp_json_encode( $items ) . ';</script>';
	}

	public static function player() {
		echo '<div id="vira-story-player" class="vira-story-player" hidden><div class="vira-story-progress"></div><button type="button" class="vira-story-close">&times;</button><div class="vira-story-media"></div><a class="vira-story-cta button" href="#">مشاهده</a></div>';
	}
}
