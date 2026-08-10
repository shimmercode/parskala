<?php
/**
 * Story submit form.
 *
 * @package Parskala Story
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Prkstory_Submit
 */
class Prkstory_Submit {
	/**
	 * Prkstory_Submit constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_prkstory_do_submit_form', array( $this, 'ajax' ) );
		add_action( 'wp_ajax_prkstory_call_submit_form', array( $this, 'call_form' ) );
		add_action( 'wp_ajax_prkstory_do_item_delete', array( $this, 'ajax_item_delete' ) );
		add_action( 'wp_ajax_prkstory_do_story_delete', array( $this, 'ajax_story_delete' ) );
	}

	/**
	 * Fixed story fields.
	 * Story cycle image and title.
	 *
	 * @return false|string
	 * @sicne 2.0.0
	 */
	public function fixed_story_fields() {
		ob_start();
		?>
		<div class="prkstory-form-row">
			<label>
				<span><?php esc_html_e( 'Story Circle Title', 'prk-story' ); ?></span>
				<input class="prkstory-input" type="text" name="prkstory-story-circle-title">
			</label>
		</div>
		<div class="prkstory-form-row">
			<label>
				<span><?php esc_html_e( 'Story Circle Image', 'prk-story' ); ?></span>
				<input class="prkstory-input prkstory-input-file prkstory-story-item-image" name="prkstory-story-circle-image" type="file" accept="image/*">
				<span class="prkstory-story-submit-preview"><?php esc_html_e( 'Upload Media', 'prk-story' ); ?></span>
			</label>
			<span class="prkstory-form-description"><small><?php esc_html_e( 'Recommended sizes: 180x180 px.' ); ?></small></span>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Get form html.
	 *
	 * @param boolean $fixed Display fixed story title and image fields.
	 * @return false|string
	 */
	public function form_content( $fixed = false ) {
		ob_start();
		?>
		<div id="prkstory-edit-modal" class="prkstory-edit-modal">
			<div class="prkstory-modal-content"></div>
		</div>
		<div id="prkstory-preview-modal" class="prkstory-preview-modal">
			<div class="prkstory-modal-content"></div>
		</div>
		<div class="prkstory-submit-form-wrapper">
			<form class="prkstory-submit-form" enctype="multipart/form-data">
				<?php
				if ( $fixed ) {
					echo $this->fixed_story_fields(); // phpcs:ignore WordPress.Security.EscapeOutput
				}
				?>
				<div class="prkstory-submit-sortable" data-repeater-list="prkstory-submit">
					<div class="prkstory-submit-item prkstory-submit-item-active" data-repeater-item>
						<div class="prkstory-form-row prkstory-expand-wrapper">
							<label>
								<span><?php esc_html_e( 'Story Link Text', 'prk-story' ); ?></span>
								<input class="prkstory-input" type="text" name="prkstory-story-link-text">
							</label>
							<span class="prkstory-form-description"><small><?php esc_html_e( 'Ie: "See Article"', 'prk-story' ); ?></small></span>
							<div class="prk-story-float-buttons">
								<button type="button" class="prkstory-float-button prkstory-move-button">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
										<path d="M 16 1.5859375 L 10.292969 7.2929688 L 11.707031 8.7070312 L 15 5.4140625 L 15 15 L 5.4140625 15 L 8.7070312 11.707031 L 7.2929688 10.292969 L 1.5859375 16 L 7.2929688 21.707031 L 8.7070312 20.292969 L 5.4140625 17 L 15 17 L 15 26.585938 L 11.707031 23.292969 L 10.292969 24.707031 L 16 30.414062 L 21.707031 24.707031 L 20.292969 23.292969 L 17 26.585938 L 17 17 L 26.585938 17 L 23.292969 20.292969 L 24.707031 21.707031 L 30.414062 16 L 24.707031 10.292969 L 23.292969 11.707031 L 26.585938 15 L 17 15 L 17 5.4140625 L 20.292969 8.7070312 L 21.707031 7.2929688 L 16 1.5859375 z"/>
									</svg>
								</button>
								<button type="button" class="prkstory-float-button prkstory-expand-button">
									<svg class="prkstory-expand-open" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
										<path d="M0 0h24v24H0z" fill="none"/>
										<path d="M7.41 18.59L8.83 20 12 16.83 15.17 20l1.41-1.41L12 14l-4.59 4.59zm9.18-13.18L15.17 4 12 7.17 8.83 4 7.41 5.41 12 10l4.59-4.59z"/>
									</svg>
									<svg class="prkstory-expand-close" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
										<path d="M0 0h24v24H0z" fill="none"/>
										<path d="M12 5.83L15.17 9l1.41-1.41L12 3 7.41 7.59 8.83 9 12 5.83zm0 12.34L8.83 15l-1.41 1.41L12 21l4.59-4.59L15.17 15 12 18.17z"/>
									</svg>
								</button>
								<button type="button" class="prkstory-float-button prkstory-delete-button" data-repeater-delete>
									<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
										<path d="M0 0h24v24H0z" fill="none"/>
										<path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
									</svg>
								</button>
							</div>
						</div>
						<div class="prkstory-slide-wrapper">
							<div class="prkstory-form-row">
								<label>
									<span><?php esc_html_e( 'Story Link', 'prk-story' ); ?></span>
									<input class="prkstory-input" type="text" name="prkstory-story-link">
								</label>
							</div>
							<div class="prkstory-form-row prkstory-edit-wrapper">
								<button type="button" class="prkstory-float-button prkstory-image-edit-button">
									<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
										<path d="M0 0h24v24H0z" fill="none"/>
										<path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
									</svg>
								</button>
								<label>
									<span><?php esc_html_e( 'Story Image or Video', 'prk-story' ); ?></span>
									<input class="prkstory-input prkstory-input-file prkstory-story-item-image" name="prkstory-story-image" type="file" accept="image/*,video/*">
									<span class="prkstory-story-submit-preview"><?php esc_html_e( 'Upload Media', 'prk-story' ); ?></span>
									<input type="hidden" name="prkstory-story-base" class="prkstory-story-item-base">
								</label>
								<span class="prkstory-form-description"><small><?php esc_html_e( 'Recommended sizes: 1080x1920 px' ); ?></small></span>
							</div>
							<div class="prkstory-form-row prkstory-story-duration-wrapper">
								<label>
									<span><?php esc_html_e( 'Duration', 'prk-story' ); ?></span>
									<input class="prkstory-input" type="number" name="prkstory-story-duration" value="3" min="1">
								</label>
							</div>
						</div>
					</div>
				</div>
				<?php wp_nonce_field( 'prkstory-submit-action', 'prkstory-submit-field' ); ?>
				<div class="prkstory-submit-footer">
					<button type="button" class="prkstory-button prkstory-create-button" data-repeater-create>
						<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
							<path d="M0 0h24v24H0z" fill="none"/>
							<path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
						</svg>
						<?php esc_html_e( 'Add Story', 'prk-story' ); ?>
					</button>
					<button class="prkstory-button prkstory-submit-button" type="submit">
						<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
							<path d="M0 0h24v24H0z" fill="none"/>
							<path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
						</svg>
						<?php esc_html_e( 'Publish', 'prk-story' ); ?>
					</button>
				</div>
			</form>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Submit for ajax handler.
	 */
	public function ajax() {
		check_ajax_referer( 'prkstory-submit-action', 'prkstory-submit-field' );

		do_action( 'prkstory_before_story_submit' );

		$items = $_POST['prkstory-submit']; // phpcs:ignore

		$user             = wp_get_current_user();
		$user_story_count = prkstory_helpers()->user_story_count( $user->ID );
		$story_item_limit = prkstory_helpers()->options( 'user_story_item_limit' );
		$story_limit      = prkstory_helpers()->options( 'user_story_limit' );

		if ( ! empty( $story_limit ) && $user_story_count >= $story_limit ) {
			wp_send_json_error(
				array(
					'message' => sprintf( /* translators: %1$s: story limit %2$s: story count */
						_n(
							'You can publish only %1$s story! Currently story count is %2$s.',
							'You can publish only %1$s stories! Currently story count is %2$s.',
							$story_limit,
							'prk-story'
						),
						$story_limit,
						$user_story_count
					),
				)
			);
		}

		if ( ! empty( $story_item_limit ) && count( $items ) > $story_item_limit ) {
			wp_send_json_error(
				array(
					'message' => sprintf( /* translators: %s: story item limit */
						_n( 'You can create only %s item per story!', 'You can create only %s items per story!', $story_item_limit, 'prk-story' ),
						$story_item_limit
					),
				)
			);
		}

		$post_title    = sanitize_text_field( $_POST['prkstory-story-circle-title'] ); // phpcs:ignore
		$has_thumbnail = isset( $_FILES['prkstory-story-circle-image'] ) && ! empty( $_FILES['prkstory-story-circle-image'] );

		if ( empty( $items ) ) {
			exit();
		}

		if ( $has_thumbnail ) {
			$post_thumbnail = media_handle_upload( 'prkstory-story-circle-image', 0 );
		}

		$image_ids = array();
		$files     = $_FILES['prkstory-submit']; // phpcs:ignore
		$i         = 0;

		foreach ( $files['name'] as $key => $value ) {
			if ( ! preg_match( '/video/i', $files['type'][ $key ]['prkstory-story-image'] ) ) {
				$base_item   = $items[ $i ];
				$base_code   = sanitize_text_field( $base_item['prkstory-story-base'] );
				$base_name   = $files['name'][ $key ]['prkstory-story-image'];
				$image_ids[] = $this->upload_with_base_64( $base_code, $base_name );
			} else {
				$file          = array(
					'name'     => $files['name'][ $key ]['prkstory-story-image'],
					'type'     => $files['type'][ $key ]['prkstory-story-image'],
					'tmp_name' => $files['tmp_name'][ $key ]['prkstory-story-image'],
					'error'    => $files['error'][ $key ]['prkstory-story-image'],
					'size'     => $files['size'][ $key ]['prkstory-story-image'],
				);
				$_FILES        = array( 'story_image_file' => $file );
				$attachment_id = media_handle_upload( 'story_image_file', 0 );

				if ( ! is_wp_error( $attachment_id ) ) {
					$image_ids[] = $attachment_id;
				}
			}
			$i++;
		}

		$post_object = array();
		for ( $i = 0; $i < count( $items ); $i++ ) {  // phpcs:ignore
			$post_object[] = array(
				'text'     => sanitize_text_field( $items[ $i ]['prkstory-story-link-text'] ),
				'link'     => esc_url( $items[ $i ]['prkstory-story-link'] ),
				'duration' => (int) $items[ $i ]['prkstory-story-duration'] > 0 ? (int) $items[ $i ]['prkstory-story-duration'] : 3,
				'index'    => $i,
				'image'    => isset( $image_ids[ $i ] ) ? array(
					'url'       => wp_get_attachment_url( $image_ids[ $i ] ),
					'id'        => $image_ids[ $i ],
					'thumbnail' => wp_get_attachment_image_url( $image_ids[ $i ], 'thumbnail', true ),
				) : array(),
			);
		}

		$status = prkstory_helpers()->options( 'user_publish_status' );

		$story_id = wp_insert_post(
			array(
				'post_author' => $user->ID,
				'post_title'  => $has_thumbnail ? $post_title : $user->display_name,
				'post_type'   => 'prk-story-user',
				'post_status' => ! empty( $status ) ? $status : 'draft',
				'meta_input'  => array(
					'prk_story_items'  => $post_object,
					'user_story_type' => $has_thumbnail ? 'public' : 'single',
				),
			)
		);

		if ( ! is_wp_error( $story_id ) ) {
			if ( $has_thumbnail && ! is_wp_error( $post_thumbnail ) ) {
				set_post_thumbnail( $story_id, $post_thumbnail );
			}

			$published_message = esc_html__( 'Story published!', 'prk-story' );

			if ( 'publish' !== $status ) {
				$published_message = esc_html__( 'Your story sent for review!', 'prk-story' );
			}

			wp_send_json_success( array( 'message' => $published_message ) );
		}

		wp_send_json_error( array( 'message' => esc_html__( 'Error! Something went wrong.', 'prk-story' ) ) );
	}

	/**
	 * Upload image with base64 code.
	 *
	 * @param string $base_64 Image code.
	 * @param string $file_name Image name.
	 * @return int|WP_Error
	 */
	public function upload_with_base_64( $base_64, $file_name ) {
		$upload_dir      = wp_upload_dir();
		$upload_path     = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;
		$image_parts     = explode( ';base64,', $base_64 );
		$decoded         = base64_decode( $image_parts[1] ); // phpcs:ignore
		$hashed_filename = md5( $file_name . microtime() ) . '_' . $file_name;
		$image_upload    = file_put_contents( $upload_path . $hashed_filename, $decoded ); // phpcs:ignore
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';

		$file             = array();
		$file['error']    = '';
		$file['tmp_name'] = $upload_path . $hashed_filename;
		$file['name']     = $hashed_filename;
		$file['type']     = 'image/png';
		$file['size']     = filesize( $upload_path . $hashed_filename );

		$file_return = wp_handle_sideload( $file, array( 'test_form' => false ) );
		$filename    = $file_return['file'];
		$attachment  = array(
			'post_mime_type' => $file_return['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
			'guid'           => $upload_dir['url'] . '/' . basename( $filename ),
		);

		$attach_id       = wp_insert_attachment( $attachment, $filename );
		$attachment_meta = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attachment_meta );

		return $attach_id;
	}

	/**
	 * Call submit form with ajax.
	 */
	public function call_form() {
		check_ajax_referer( 'prkstory-nonce', 'nonce' );

		$type = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : null;

		if ( ! in_array( $type, array( 'single', 'public' ), true ) ) {
			exit();
		}

		$sent_user_id = isset( $_POST['id'] ) ? wp_unslash( (int) $_POST['id'] ) : null;

		ob_start();

		if ( 'single' === $type ) {
			$author_id       = get_current_user_id();
			$current_stories = prkstory_creator()->get_merged_stories( $author_id );

			if ( ! empty( $current_stories ) && ! is_wp_error( $current_stories ) ) :
				?>
				<div class="prkstory-current-stories">
					<?php
					foreach ( $current_stories[0]['items'] as $current_story ) {
						?>
						<div class="prkstory-story-preview">
							<?php if ( 'photo' === $current_story['type'] ) : ?>
								<span
										class="prkstory-preview-image"
										data-src="<?php echo esc_url( $current_story['src'] ); ?>"
										data-type="image"
										style="background-image: url(<?php echo esc_url( $current_story['src'] ); ?>);"></span>
							<?php else : ?>
								<span
										class="prkstory-preview-image"
										data-src="<?php echo esc_url( $current_story['src'] ); ?>"
										data-type="video"
										style="background-image: url(<?php echo esc_url( PRKSTORY_DIR . 'public/img/video-player.png' ); ?>);"></span>
							<?php endif; ?>
							<div class="prkstory-preview-meta">
								<ul>
									<li>
										<span><?php esc_html_e( 'Link Text:', 'prk-story' ); ?></span>
										<span><?php echo esc_html( $current_story['linkText'] ); ?></span>
									</li>
									<li>
										<span><?php esc_html_e( 'Link:', 'prk-story' ); ?></span>
										<span>
											<a href="<?php echo esc_html( $current_story['link'] ); ?>"><?php echo esc_html( $current_story['link'] ); ?></a>
										</span>
									</li>
									<li>
										<span><?php esc_html_e( 'Date:', 'prk-story' ); ?></span>
										<span><?php echo esc_html( prkstory_helpers()->date_time( $current_story['box'] ) ); ?></span>
									</li>
								</ul>
							</div>
							<button
									type="button"
									class="prkstory-float-button prkstory-delete-item prkstory-delete-story-item"
									data-id="<?php echo esc_attr( $current_story['box'] ); ?>"
									data-index="<?php echo esc_attr( $current_story['index'] ); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0z" fill="none"/>
									<path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
								</svg>
							</button>
						</div>
						<?php
					}
					?>
				</div>
			<?php endif; ?>
			<?php
			echo $this->form_content(); // phpcs:ignore WordPress.Security.EscapeOutput
		} else {
			$author_id       = $sent_user_id;
			$author_args     = array(
				'post_type'  => 'prk-story-user',
				'post__in'   => array(),
				'author__in' => array( $author_id ),
				'meta_key'   => 'user_story_type', // phpcs:ignore
				'meta_value' => 'public', // phpcs:ignore
			);
			$current_stories = prkstory_creator()->get_stories( 0, array( $author_id ), $author_args );

			if ( ! empty( $current_stories ) && ! is_wp_error( $current_stories ) ) :
				?>
				<div class="prkstory-current-stories">
					<?php
					foreach ( $current_stories as $current_story ) {
						?>
						<div class="prkstory-story-preview">
							<span
									class="prkstory-preview-image"
									data-src="<?php echo esc_url( $current_story['photo'] ); ?>"
									data-type="image"
									style="background-image: url(<?php echo esc_url( $current_story['photo'] ); ?>);"></span>
							<div class="prkstory-preview-meta">
								<ul>
									<li>
										<span><?php esc_html_e( 'Name:', 'prk-story' ); ?></span>
										<span><?php echo esc_html( $current_story['name'] ); ?></span>
									</li>
									<li>
										<span><?php esc_html_e( 'Date:', 'prk-story' ); ?></span>
										<span><?php echo esc_html( prkstory_helpers()->date_time( $current_story['box'] ) ); ?></span>
									</li>
								</ul>
							</div>
							<button
									type="button"
									class="prkstory-float-button prkstory-delete-item prkstory-delete-story"
									data-id="<?php echo esc_attr( $current_story['box'] ); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0z" fill="none"/>
									<path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
								</svg>
							</button>
						</div>
						<?php
					}
					?>
				</div>
			<?php endif; ?>
			<?php
			echo $this->form_content( true ); // phpcs:ignore WordPress.Security.EscapeOutput
		}

		wp_send_json_success( array( 'data' => ob_get_clean() ) );
	}

	/**
	 * Delete story item from author story box.
	 */
	public function ajax_item_delete() {
		check_ajax_referer( 'prkstory-nonce', 'nonce' );

		do_action( 'prkstory_before_item_delete' );

		$box_id = isset( $_POST['id'] ) ? absint( wp_unslash( $_POST['id'] ) ) : null;
		$index  = isset( $_POST['index'] ) ? absint( wp_unslash( $_POST['index'] ) ) : null;

		if ( empty( $box_id ) ) {
			exit();
		}

		$box = get_post( $box_id );

		if ( 'prk-story-user' !== get_post_type( $box_id ) ) {
			exit();
		}

		$user = wp_get_current_user();

		if ( (int) $user->ID !== (int) $box->post_author ) {
			exit();
		}

		$items = get_post_meta( $box_id, 'prk_story_items', true );

		$items[ $index ]['disabled'] = true;

		update_post_meta( $box_id, 'prk_story_items', $items );

		wp_send_json_success();
	}

	/**
	 * Delete story box from author.
	 */
	public function ajax_story_delete() {
		check_ajax_referer( 'prkstory-nonce', 'nonce' );

		do_action( 'prkstory_before_story_delete' );

		$box_id = isset( $_POST['id'] ) ? absint( wp_unslash( $_POST['id'] ) ) : null;
		$index  = isset( $_POST['index'] ) ? absint( wp_unslash( $_POST['index'] ) ) : null;

		if ( empty( $box_id ) ) {
			exit();
		}

		$box = get_post( $box_id );

		if ( 'prk-story-user' !== get_post_type( $box_id ) ) {
			exit();
		}

		$user = wp_get_current_user();

		if ( (int) $user->ID !== (int) $box->post_author ) {
			exit();
		}

		wp_update_post(
			array(
				'ID'          => $box_id,
				'post_status' => 'draft',
			)
		);

		wp_send_json_success();
	}
}

new Prkstory_Submit();
