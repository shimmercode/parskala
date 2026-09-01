<?php
/**
 * Dynamic contents class
 *
 * @package parskala Story 
 */

/**
 * Class Prkstory_Dynamic_Contents
 */
class Prkstory_Dynamic_Contents {
	/**
	 * Display story adding button.
	 *
	 * @param int $user_id User ID.
	 * @param array $args Story shortcode args.
	 *
	 * @return false|string
	 */
	public function story_adding_button( $user_id, $args ) {
		ob_start();
		$type        = $args['type'];
		$render_type = $type;
		$style       = $args['style'];

		if ( 'activities' === $type ) {
			$render_type = 'user-single';
		}

		switch ( $type ) {
			case 'user-public':
				$add_title = esc_html__( 'Add highlight story', 'prk-story' );
				break;

			default:
				$add_title = esc_html__( 'Add story', 'prk-story' );
		}

		$tag      = 'button';
		$tag_type = 'type="button"';

		if ( 'activities' === $type && $args['canAdd'] && ! is_user_logged_in() ) {
			$login_url = isset( $args['loginUrl'] ) && ! empty( $args['loginUrl'] ) ? $args['loginUrl'] : PRKSTORY()->get_login_url();
			$tag       = 'a';
			$tag_type  = 'href="' . esc_url( $login_url ) . '"';
		}

		switch ( $style ) {
			case 'instagram':
				?>
				<<?php echo $tag; ?>
					<?php echo $tag_type; ?>
					class="prkstory-add prkstory-add-<?php echo esc_attr( $render_type ); ?> prkstory-slider-item prkstory-feed-item-ins"
					data-type="<?php echo esc_attr( $render_type ); ?>"
					title="<?php echo $add_title; ?>"
				>
					<span class="prkstory-circle-image">
						<?php echo get_avatar( $user_id ); ?>
						<span class="prkstory-add-icon">
							<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none" /><path fill="#64B5F6" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" /></svg>
						</span>
					</span>
					<span class="prkstory-circle-title"><?php echo $add_title; ?></span>
				</<?php echo $tag; ?>>
				<?php
				break;

			case 'facebook':
				?>
				<<?php echo $tag; ?>
					<?php echo $tag_type; ?>
					class="prkstory-add prkstory-add-<?php echo esc_attr( $render_type ); ?> prkstory-slider-item prkstory-feed-item-fb"
					data-type="<?php echo esc_attr( $render_type ); ?>"
					title="<?php echo $add_title; ?>"
				>
					<span class="prkstory-fb-cover">
						<?php echo get_avatar( $user_id, 150 ); ?>
					</span>
					<span class="prkstory-fb-title"><?php echo $add_title; ?></span>
					<span class="prkstory-fb-add-icon">
						<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none" /><path fill="#64B5F6" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" /></svg>
					</span>
				</<?php echo $tag; ?>>
				<?php
				break;
		}

		return ob_get_clean();
	}
}

/**
 * Class returner function.
 *
 * @return Prkstory_Dynamic_Contents
 */
function prkstory_dynamic_contents() {
	return new Prkstory_Dynamic_Contents();
}
