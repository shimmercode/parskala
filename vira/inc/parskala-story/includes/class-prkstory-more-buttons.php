<?php
/**
 * Story modal more buttons.
 *
 * @package Prkstory
 */

/**
 * Story modal buttons class.
 *
 * @since 3.0.0
 */
class Prkstory_More_Buttons {
	/**
	 * Class constructor.
	 */
	public function __construct() {
		/**
		 * Get buttons html.
		 */
		add_action( 'wp_ajax_prkstory_modal_more_buttons', array( $this, 'get_buttons' ) );
		add_action( 'wp_ajax_nopriv_prkstory_modal_more_buttons', array( $this, 'get_buttons' ) );

		/**
		 * Delete story.
		 */
		add_action( 'wp_ajax_prkstory_delete_story', array( $this, 'delete_story' ) );

	}

	/**
	 * Get buttons html.
	 */
	public function get_buttons() {
		check_ajax_referer( 'prkstory-nonce', 'nonce' );

		$story_id = isset( $_POST['id'] ) ? (int) $_POST['id'] : null;
		$type     = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : null;

		if ( empty( $story_id ) || empty( $type ) ) {
			wp_send_json_error( array( 'message' => 'error 3000' ) );
		}

		if ( ! in_array( $type, array( 'box', 'user-single', 'user-public', 'activities' ), true ) ) {
			wp_send_json_error( array( 'message' => 'error 3001' ) );
		}

		if ( 'publish' !== get_post_status( $story_id ) ) {
			wp_send_json_error( array( 'message' => 'error 3002' ) );
		}

		if ( ! in_array( get_post_type( $story_id ), array( 'prk-story','prkstory-user','prkstory-public'), true ) ) {
			wp_send_json_error( array( 'message' => 'error 3003' ) );
		}

		$user_can_manage = prkstory_helpers()->user_can_manage_story( null, $story_id );

		ob_start();
		?>
		<div class="prkstory-more-buttons">
			<ul class="prkstory-more-buttons-list">
				<?php do_action( 'prkstory_before_more_buttons' ); ?>

				<?php if ( $user_can_manage && 'box' !== $type ) : ?>
					<li class="prkstory-more-buttons-list-item">
						<button type="button" class="prkstory-more-buttons-button prkstory-more-buttons-delete prkstory-more-buttons-delete-first" data-id="<?php echo esc_attr( $story_id ); ?>"><?php esc_html_e( 'Delete', 'prk-story' ); ?></button>
					</li>
				<?php endif; ?>


				<li class="prkstory-more-buttons-list-item">
					<button type="button" class="prkstory-more-buttons-button prkstory-more-buttons-cancel prkstory-more-close"><?php esc_html_e( 'Cancel', 'prk-story' ); ?></button>
				</li>
				<?php do_action( 'prkstory_after_more_buttons' ); ?>
			</ul>
		</div>
		<?php
		$result = ob_get_clean();

		wp_send_json_success( array( 'result' => $result ) );
	}


	/**
	 * Delete story ajax handler.
	 *
	 * @since 3.0.0
	 */
	public function delete_story() {
		check_ajax_referer( 'prkstory-nonce', 'nonce' );

		$story_id = isset( $_POST['id'] ) ? (int) wp_unslash( $_POST['id'] ) : null;
		$rest_id  = isset( $_POST['rest_id'] ) ? sanitize_text_field( wp_unslash( $_POST['rest_id'] ) ) : null;
		$type     = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : null;

		if ( empty( $story_id ) || empty( $type ) ) {
			wp_send_json_error( array( 'message' => 'error ajax_delete_story_1' ) );
		}

		if ( ! in_array( $type, array( 'user-single', 'user-public', 'activities' ), true ) ) {
			wp_send_json_error( array( 'message' => 'error ajax_delete_story_2' ) );
		}

		if ( 'publish' !== get_post_status( $story_id ) ) {
			wp_send_json_error( array( 'message' => 'error ajax_delete_story_3' ) );
		}

		if ( ! in_array( get_post_type( $story_id ), array( 'prkstory-user', 'prkstory-public' ), true ) ) {
			wp_send_json_error( array( 'message' => 'error ajax_delete_story_4' ) );
		}

		$user_can_manage = prkstory_helpers()->user_can_manage_story( get_current_user_id(), $story_id );

		if ( ! $user_can_manage ) {
			wp_send_json_error( array( 'message' => 'error ajax_delete_story_5' ) );
		}

		$status = prkstory_helpers()->options( 'user_deleting_status', 'draft' );

		if ( 'draft' === $status || 'trash' === $status ) {
			wp_update_post(
				array(
					'ID'          => $story_id,
					'post_status' => $status,
				)
			);
		}

		if ( 'delete' === $status ) {
			wp_delete_post( $story_id, true );
		}

		ob_start();
		?>
		<div class="prkstory-report-success">
			<div class="prkstory-report-success-head">
				<svg class="prkstory-svg-tick" xmlns="http://www.w3.org/2000/svg" height="48px" width="48px" fill="#58c322" viewBox="0 0 48 48">
					<path d="M24 48C10.8 48 0 37.2 0 24S10.8 0 24 0s24 10.8 24 24-10.8 24-24 24zm0-45C12.4 3 3 12.4 3 24s9.4 21 21 21 21-9.4 21-21S35.6 3 24 3z"></path>
					<path d="M19.9 33.7c-.4 0-.8-.2-1.1-.4l-8.2-8.2c-.6-.6-.6-1.5 0-2.1.6-.6 1.5-.6 2.1 0l7.1 7.1 15.3-15.3c.6-.6 1.5-.6 2.1 0 .6.6.6 1.5 0 2.1L21 33.3c-.3.2-.7.4-1.1.4z"></path>
				</svg>
			</div>
			<div class="prkstory-report-success-body">
				<h4 class="prkstory-report-success-title"><?php esc_html_e( 'It\'s done!', 'prk-story' ); ?></h4>
				<p><?php esc_html_e( 'Your story has been deleted successfully.', 'prk-story' ); ?></p>
			</div>
			<button type="button" class="prkstory-report-success-close prkstory-more-close"><?php esc_html_e( 'Close', 'prk-story' ); ?></button>
		</div>
		<?php
		$result = ob_get_clean();

		switch ( $type ) {
			case 'activities':
				$items = prkstory_creator()->get_activity_stories();
				break;

			case 'user-single':
				$items = prkstory_creator()->get_user_single_stories( $rest_id );
				break;
		}

		wp_send_json_success(
			array(
				'result' => $result,
				'items'  => wp_json_encode( $items ),
			)
		);
	}
}

new Prkstory_More_Buttons();
