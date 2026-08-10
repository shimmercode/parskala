<?php
/**
 * Class Prkstory_Helpers
 * Plugin helper functions.
 *
 * @package parskala Story
 * @sicne 1.2.0
 * @author parskala
 */

/**
 * Class Prkstory_Helpers
 */
class Prkstory_Helpers {
	/**
	 * Plugin options.
	 *
	 * @var $options
	 */
	public $options;

	/**
	 * Prkstory_Helpers constructor.
	 */
	public function __construct() {
		$this->options = get_option( 'prk_option' );
	}

	/**
	 * Story strings.
	 *
	 * @return array
	 */
	public function story_strings() {
		return array(
			'homeUrl'              => home_url(),
			'ajaxUrl'              => admin_url( 'admin-ajax.php' ),
			'apply'                => esc_html__( 'Apply', 'prk-story' ),
			'yes'                  => esc_html__( 'Yes', 'prk-story' ),
			'close'                => esc_html__( 'Close', 'prk-story' ),
			'nonce'                => wp_create_nonce( 'prkstory-nonce' ),
			'editor_lang'          => array(
				'Undo'            => esc_html__( 'Undo', 'prk-story' ),
				'Redo'            => esc_html__( 'Redo', 'prk-story' ),
				'Reset'           => esc_html__( 'Reset', 'prk-story' ),
				'Delete'          => esc_html__( 'Delete', 'prk-story' ),
				'Delete All'      => esc_html__( 'Delete All', 'prk-story' ),
				'Crop'            => esc_html__( 'Crop', 'prk-story' ),
				'Flip'            => esc_html__( 'Flip', 'prk-story' ),
				'Rotate'          => esc_html__( 'Rotate', 'prk-story' ),
				'Draw'            => esc_html__( 'Draw', 'prk-story' ),
				'Shape'           => esc_html__( 'Shape', 'prk-story' ),
				'Icon'            => esc_html__( 'Icon', 'prk-story' ),
				'Text'            => esc_html__( 'Text', 'prk-story' ),
				'Mask'            => esc_html__( 'Mask', 'prk-story' ),
				'Filter'          => esc_html__( 'Filter', 'prk-story' ),
				'Custom'          => esc_html__( 'Custom', 'prk-story' ),
				'Square'          => esc_html__( 'Square', 'prk-story' ),
				'Apply'           => esc_html__( 'Apply', 'prk-story' ),
				'Cancel'          => esc_html__( 'Cancel', 'prk-story' ),
				'Flip X'          => esc_html__( 'Flip X', 'prk-story' ),
				'Flip Y'          => esc_html__( 'Flip Y', 'prk-story' ),
				'Range'           => esc_html__( 'Range', 'prk-story' ),
				'Free'            => esc_html__( 'Free', 'prk-story' ),
				'Straight'        => esc_html__( 'Straight', 'prk-story' ),
				'Rectangle'       => esc_html__( 'Rectangle', 'prk-story' ),
				'Circle'          => esc_html__( 'Circle', 'prk-story' ),
				'Triangle'        => esc_html__( 'Triangle', 'prk-story' ),
				'Fill'            => esc_html__( 'Fill', 'prk-story' ),
				'Stroke'          => esc_html__( 'Stroke', 'prk-story' ),
				'Arrow'           => esc_html__( 'Arrow', 'prk-story' ),
				'Arrow-2'         => esc_html__( 'Arrow-2', 'prk-story' ),
				'Arrow-3'         => esc_html__( 'Arrow-3', 'prk-story' ),
				'Star-1'          => esc_html__( 'Star-1', 'prk-story' ),
				'Star-2'          => esc_html__( 'Star-2', 'prk-story' ),
				'Polygon'         => esc_html__( 'Polygon', 'prk-story' ),
				'Location'        => esc_html__( 'Location', 'prk-story' ),
				'Heart'           => esc_html__( 'Heart', 'prk-story' ),
				'Bubble'          => esc_html__( 'Bubble', 'prk-story' ),
				'Custom icon'     => esc_html__( 'Custom icon', 'prk-story' ),
				'Color'           => esc_html__( 'Color', 'prk-story' ),
				'Bold'            => esc_html__( 'Bold', 'prk-story' ),
				'Italic'          => esc_html__( 'Italic', 'prk-story' ),
				'Underline'       => esc_html__( 'Underline', 'prk-story' ),
				'Left'            => esc_html__( 'Left', 'prk-story' ),
				'Center'          => esc_html__( 'Center', 'prk-story' ),
				'Underline'       => esc_html__( 'Underline', 'prk-story' ),
				'Text size'       => esc_html__( 'Text size', 'prk-story' ),
				'Mask'            => esc_html__( 'Mask', 'prk-story' ),
				'Load Mask Image' => esc_html__( 'Load Mask Image', 'prk-story' ),
				'Grayscale'       => esc_html__( 'Grayscale', 'prk-story' ),
				'Invert'          => esc_html__( 'Invert', 'prk-story' ),
				'Sepia'           => esc_html__( 'Sepia', 'prk-story' ),
				'Sepia2'          => esc_html__( 'Sepia2', 'prk-story' ),
				'Blur'            => esc_html__( 'Blur', 'prk-story' ),
				'Sharpen'         => esc_html__( 'Sharpen', 'prk-story' ),
				'Emboss'          => esc_html__( 'Emboss', 'prk-story' ),
				'Remove White'    => esc_html__( 'Remove White', 'prk-story' ),
				'Distance'        => esc_html__( 'Distance', 'prk-story' ),
				'Brightness'      => esc_html__( 'Brightness', 'prk-story' ),
				'Noise'           => esc_html__( 'Noise', 'prk-story' ),
				'Pixelate'        => esc_html__( 'Pixelate', 'prk-story' ),
				'Color Filter'    => esc_html__( 'Color Filter', 'prk-story' ),
				'Threshold'       => esc_html__( 'Threshold', 'prk-story' ),
				'Tint'            => esc_html__( 'Tint', 'prk-story' ),
				'Multiply'        => esc_html__( 'Multiply', 'prk-story' ),
				'Blend'           => esc_html__( 'Blend', 'prk-story' ),
			),
			'opener'               => ! empty( get_option( 'prk-story' )['opener'] ) ? esc_js( get_option( 'prk-story' )['opener'] ) : 'false',
			'delete_story_confirm' => esc_html__( 'Are you sure want to delete this story item?', 'prk-story' ),
			'image_compression'    => array(
				'enabled' => ! empty( $this->options( 'image_compression' ) ),
				'level'   => $this->options( 'image_compression_level' ),
				'width'   => $this->options( 'image_max_width' ),
				'height'  => $this->options( 'image_max_height' ),
			),
			'image_editor'         => array(),
			'media_error'          => esc_html__( 'Please add an image or video for all story items!', 'prk-story' ),
			'allowed_file_types'   => $this->get_allowed_file_types(),
			'max_file_size'        => prkstory_helpers()->options( 'max_file_size', 10 ),
			'max_file_size_text'   => esc_html__( 'File is too large!', 'prk-story' ),
			'max_file_size_error'  => esc_html__( 'Allowed max file size is: {filesize}.', 'prk-story' ),
			'deleteConfirm'        => esc_html__( 'Are you sure want to delete?', 'prk-story' ),
		);
	}

	/**
	 * Admin js vars.
	 *
	 * @return array
	 * @since 3.0.0
	 */
	public function story_admin_strings() {
		return array(
			'homeUrl' => home_url(),
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'prkstory-admin-nonce' ),
		);
	}

	/**
	 * Get allowed file types.
	 *
	 * @param string $return_type Return type. String or Array.
	 *
	 * @return array|string
	 */
	public function get_allowed_file_types( $return_type = 'string' ) {
		$image_types = prkstory_helpers()->options( 'allowed_image_types', array() );
		$video_types = prkstory_helpers()->options( 'allowed_video_types', array() );

		$image_types = ! empty( $image_types ) ? $image_types : array();
		$video_types = ! empty( $video_types ) ? $video_types : array();

		if ( 'string' === $return_type ) {
			$allowed_images = array();
			if ( ! empty( $image_types ) ) {
				foreach ( $image_types as $image_type ) {
					$allowed_images[] = 'image/' . $image_type;
				}
			} else {
				$allowed_images = array( 'image/*' );
			}

			$allowed_videos = array();
			if ( ! empty( $video_types ) ) {
				foreach ( $video_types as $video_type ) {
					$allowed_videos[] = 'video/' . $video_type;
				}
			} else {
				$allowed_videos = array( 'video/*' );
			}

			$types = array_merge( $allowed_images, $allowed_videos );

			return wp_json_encode( wp_unslash( $types ) );
		}

		return array_merge( $image_types, $video_types );
	}

	/**
	 * Get plugin script mode.
	 *
	 * @return mixed|string
	 * @sicne 1.2.0
	 */
	public function script_mode() {
		return isset( $this->options['script_mode'] ) ? $this->options['script_mode'] : 'automatic';
	}

	/**
	 * Get story box ids and names.
	 * Maybe can use for any <select> item.
	 * Returns: (array) box_id => box_name
	 *
	 * @param boolean $choose Choose options.
	 *
	 * @return array Story box ids.
	 * @sicne 1.2.0
	 */
	public function get_story_boxes( $choose = false ) {
		$args = array(
			'order'          => 'DESC',
			'post_type'      => 'prk-story-box',
			'posts_per_page' => - 1,
		);

		$query = new \WP_Query( $args );

		$arr = array();

		if ( $choose ) {
			$arr[0] = esc_html__( 'Select a Story Box', 'prk-story' );
		}

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$arr[ get_the_ID() ] = get_the_title();
			}
		}

		wp_reset_postdata();

		return $arr;
	}

	/**
	 * Get options from database.
	 *
	 * @param string $key Option key.
	 * @param string $default Default value.
	 *
	 * @return mixed|null
	 */
	public function options( $key, $default = null ) {
		return isset( $this->options[ $key ] ) ? $this->options[ $key ] : $default;
	}

	/**
	 * Get styling options.
	 *
	 * @param int $box_id Story box id.
	 * @param string $option_key Option key.
	 * @param boolean $check Check metabox value for condition.
	 * @param boolean $from_opt Fetch from only options.
	 * @param string $default Default val.
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	public function get_option( $box_id, $option_key, $check = 'style_type', $from_opt = false, $default = null ) {
		$opt = $this->options;

		if ( $from_opt ) {
			return isset( $opt[ $option_key ] ) ? $opt[ $option_key ] : $default;
		}

		$box_meta = get_post_meta( $box_id, 'prk-story-box-metabox', true );

		if ( empty( $check ) ) {
			$check = 'style_type';
		}

		if ( isset( $box_meta[ $check ] ) && 'global' === $box_meta[ $check ] ) {
			return isset( $opt[ $option_key ] ) ? $opt[ $option_key ] : $default;
		}

		if ( isset( $box_meta[ $check ] ) && isset( $box_meta[ $option_key ] ) && ( 'custom' === $box_meta[ $check ] || 'global' !== $box_meta[ $check ] ) ) {
			return $box_meta[ $option_key ];
		}

		return isset( $opt[ $option_key ] ) ? $opt[ $option_key ] : $default;
	}

	/**
	 * Get story circle thumbnail size.
	 * It is available only when thumbnail option is set true.
	 *
	 * @param int $box_id Story box id.
	 *
	 * @return string
	 * @since 1.0.1
	 */
	public function story_thumbnail_size( $box_id ) {
		$skin = $this->get_option( $box_id, 'style', 'style' );

		switch ( $skin ) {
			case 'snapgram' === $skin && $this->options( 'circle_size' ):
				$size = 'prkstory-circle';
				break;

			case 'snapssenger' === $skin && $this->options( 'square_size' ):
				$size = 'prkstory-square';
				break;

			case 'vemdezap' === $skin && $this->options( 'list_size' ):
				$size = 'prkstory-list';
				break;

			default:
				$size = 'full';
		}

		return $size;
	}

	/**
	 * Create an array from comma separated string.
	 *
	 * @param string $val Comma separated string.
	 *
	 * @return array
	 */
	public function comma_separated_arr( $val ) {
		return array_map( 'trim', preg_split( '@,@', $val, null, PREG_SPLIT_NO_EMPTY ) );
	}

	/**
	 * Display post's date and time by WordPress settings.
	 *
	 * @param int $id Post ID.
	 *
	 * @return false|string
	 */
	public function date_time( $id ) {
		return get_the_date( sprintf( '%s %s', get_option( 'date_format' ), get_option( 'time_format' ) ), $id );
	}

	/**
	 * Calculate user's live stories count.
	 *
	 * @param int $user_id User id.
	 * @param string $post_type WP Post type name.
	 *
	 * @return int|void
	 */
	public function user_story_count( $user_id, $post_type = 'prkstory-user' ) {
		return count_user_posts( $user_id, $post_type, true );
	}

	/**
	 * Get story items count.
	 *
	 * @param integer $user_id User ID.
	 * @param integer $parent Parent post ID.
	 * @param string $post_type Post type.
	 *
	 * @return int
	 * @since 3.0.0
	 */
	public function user_story_item_count( $user_id, $parent = '', $post_type = 'prkstory-public' ) {
		$query = new WP_Query(
			array(
				'post_type'      => $post_type,
				'posts_per_page' => - 1,
				'post_parent'    => $parent,
				'post_status'    => 'publish',
				'author'         => $user_id,
			)
		);

		return $query->found_posts;
	}

	/**
	 * Get user avatar url.
	 *
	 * @param int $user_id User id.
	 * @param int $size Avatar image size.
	 *
	 * @sicne 2.4.0
	 */
	public function get_user_avatar( $user_id = null, $size = 96 ) {
		$avatar_url = get_avatar_url( $user_id, array( 'size' => $size ) );

		return apply_filters( 'prkstory_avatar_url', $avatar_url );
	}

	/**
	 * Get story's author name.
	 *
	 * @param int $user_id User unique ID.
	 *
	 * @return mixed|void
	 *
	 * @sicne 2.4.0
	 */
	public function get_user_name( $user_id = null ) {
		$user_data = get_userdata( $user_id );
		$name      = null;

		if ( $user_data ) {
			$name = $user_data->display_name;
		}

		return apply_filters( 'prkstory_author_name', $name, $user_id );
	}

	/**
	 * Get user public profile url.
	 *
	 * @param integer $user_id User DB ID.
	 */
	public function get_user_profile_url( $user_id ) {
		$url = get_author_posts_url( $user_id );

		return apply_filters( 'prkstory_profile_url', $url, $user_id );
	}

	/**
	 * Get user public profile url.
	 *
	 * @param integer $user_id User DB ID.
	 *
	 * @sicne 3.0.0
	 */
	public function get_user_friends( $user_id ) {
		$friends = array();

		return apply_filters( 'prkstory_user_friends', $friends, $user_id );
	}

	/**
	 * Get displayed user ID.
	 *
	 * @sicne 3.0.0
	 */
	public function get_displayed_user_id() {
		$user_id = get_current_user_id();

		return apply_filters( 'prkstory_displayed_user_id', $user_id );
	}

	/**
	 * Return login url.
	 *
	 * @return mixed|void
	 */
	public function get_login_url() {
		return apply_filters( 'prkstory_login_url', wp_login_url() );
	}

	/**
	 * Convert time string to second.
	 * Ie: 03:30 => 210
	 *
	 * @param string $time Time string.
	 *
	 * @return float|int|string|null
	 */
	public function time_to_sec( $time ) {
		if ( empty( $time ) ) {
			return 3;
		}

		$seconds  = 0;
		$time_arr = explode( ':', $time );

		$seconds += (int) $time_arr[0] * 60;
		$seconds += (int) $time_arr[1];

		return (int) $seconds;
	}

	/**
	 * Calculate time ago.
	 *
	 * @param int $post_id Story post id.
	 *
	 * @return string
	 */
	public function time_ago( $post_id ) {
		return human_time_diff( get_the_time( 'U', $post_id ), current_time( 'timestamp' ) ); // phpcs:ignore
	}

	/**
	 * Get admin notice is active.
	 *
	 * @param string $notice Notice name.
	 *
	 * @since 3.0.
	 */
	public function get_admin_notice( $notice ) {
		$notices = get_option( 'prkstory_admin_notices' );

		return isset( $notices[ $notice ] ) ? $notices[ $notice ] : false;
	}

	/**
	 * Update admin notice value.
	 *
	 * @param string $notice Notice name.
	 * @param strong|boolean $value Notice value.
	 *
	 * @since 3.0.0
	 */
	public function update_admin_notice( $notice, $value ) {
		$notices            = get_option( 'prkstory_admin_notices' );
		$notices[ $notice ] = $value;
		update_option( 'prkstory_notices', $notices );
	}

	/**
	 * Get div loader html.
	 *
	 * @return string
	 *
	 * @since 3.0.0
	 */
	public function loader_html() {
		return '<div class="prkstory-loader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
	}

	/**
	 * Get user unsafe IP address.
	 *
	 * @return false|string
	 */
	public function get_user_ip() {
		$client_ip = false;

		// In order of preference, with the best ones for this purpose first.
		$address_headers = array(
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR',
		);

		foreach ( $address_headers as $header ) {
			if ( array_key_exists( $header, $_SERVER ) ) {
				/*
				 * HTTP_X_FORWARDED_FOR can contain a chain of comma-separated
				 * addresses. The first one is the original client. It can't be
				 * trusted for authenticity, but we don't need to for this purpose.
				 */
				$address_chain = explode( ',', $_SERVER[ $header ] ); // phpcs:ignore
				$client_ip     = trim( $address_chain[0] );

				break;
			}
		}

		if ( ! $client_ip ) {
			return false;
		}

		$anon_ip = wp_privacy_anonymize_ip( $client_ip, true );

		if ( '0.0.0.0' === $anon_ip || '::' === $anon_ip ) {
			return false;
		}

		return $anon_ip;
	}

	/**
	 * Check if user can manage story.
	 *
	 * @param integer $user_id User ID.
	 * @param integer $story_id Story ID.
	 */
	public function user_can_manage_story( $user_id, $story_id ) {
		// If user is admin.
		if ( current_user_can( 'manage_options' ) ) {
			return true;
		}

		/**
		 * Check post_type.
		 * post_type must be 'prk-story'.
		 */
		if ( ! in_array( get_post_type( $story_id ), array('prk-story','prkstory-user', 'prkstory-public' ), true ) ) {
			return false;
		}

		if ( empty( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		if ( empty( $story_id ) ) {
			$story_id = get_the_ID();
		}

		return (int) get_post( $story_id )->post_author === (int) $user_id;
	}

	/**
	 * Re-Order users by last uploaded story time.
	 * Works for only single stories.
	 *
	 * @param array $user_ids User IDs.
	 *
	 * @return array
	 * @since 3.0.0
	 */
	public function order_users( $user_ids ) {
		$args = array(
			'number'     => - 1,
			'order'      => 'DESC',
			'fields'     => 'ID',
			'orderby'    => 'meta_value',
			'include'    => $user_ids,
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key'     => 'prkstory_last_updated',
					'value'   => current_time( 'mysql' ),
					'type'    => 'DATE',
					'compare' => '<=',
				),
				array(
					'key'     => 'prkstory_last_updated',
					'compare' => 'NOT EXISTS',
				),
			),
		);

		$user_query = new WP_User_Query( $args );

		return array_map( 'intval', $user_query->get_results() );
	}


	/**
	 * Get video cover for stories.
	 *
	 * @param $story_id int Story post ID.
	 *
	 * @return string Cover image URL.
	 * @since 3.0.0
	 */
	public function get_video_cover( $story_id ) {
		$cover     = get_post_meta( $story_id, 'video_cover', true );
		$cover_url = ! empty( $cover ) ? wp_get_attachment_image_url( $cover, 'full' ) : PRKSTORY_DIR . '/public/img/video-cover.png';

		return apply_filters( 'prkstory_preview_image', esc_url( $cover_url ) );
	}

}

/**
 * Class returner function.
 *
 * @return Prkstory_Helpers
 */
function prkstory_helpers() {
	return new Prkstory_Helpers();
}

function PRKSTORY() {
	return new Prkstory_Helpers();
}
