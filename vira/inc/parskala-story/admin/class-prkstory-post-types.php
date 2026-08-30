<?php
/**
 * Create custom post types.
 *
 * @package Parskala Story
 */

/**
 * Class Prkstory_Post_Types
 *
 * @author parskala
 */
class Prkstory_Post_Types {
	/**
	 * Prkstory_Post_Types constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'create_story_post_type' ) );
		add_action( 'init', array( $this, 'create_story_box_post_type' ) );
		add_action( 'admin_footer-post-new.php', array( $this, 'print_scripts' ) );
		add_action( 'admin_footer-post.php', array( $this, 'print_scripts' ) );

	}

	/**
	 * Create story post type.
	 * post_type = prk-story
	 *
	 * @since 1.0.0
	 */
	public function create_story_post_type() {
		$labels = array(
			'name'                  => esc_html_x( 'Stories', 'Post Type General Name', 'parskala' ),
			'singular_name'         => esc_html_x( 'Story', 'Post Type Singular Name', 'parskala' ),
			'menu_name'             => esc_html_x( 'Stories', 'Admin Menu text', 'parskala' ),
			'name_admin_bar'        => esc_html_x( 'Story', 'Add New on Toolbar', 'parskala' ),
			'archives'              => esc_html__( 'Story Archives', 'parskala' ),
			'attributes'            => esc_html__( 'Story Attributes', 'parskala' ),
			'parent_item_colon'     => esc_html__( 'Parent Story:', 'parskala' ),
			'all_items'             => esc_html__( 'All Stories', 'parskala' ),
			'add_new_item'          => esc_html__( 'Add New Story', 'parskala' ),
			'add_new'               => esc_html__( 'Add New Story', 'parskala' ),
			'new_item'              => esc_html__( 'New Story', 'parskala' ),
			'edit_item'             => esc_html__( 'Edit Story', 'parskala' ),
			'update_item'           => esc_html__( 'Update Story', 'parskala' ),
			'view_item'             => esc_html__( 'View Story', 'parskala' ),
			'view_items'            => esc_html__( 'View Stories', 'parskala' ),
			'search_items'          => esc_html__( 'Search Story', 'parskala' ),
			'not_found'             => esc_html__( 'Not found', 'parskala' ),
			'not_found_in_trash'    => esc_html__( 'Not found in trash', 'parskala' ),
			'featured_image'        => esc_html__( 'Featured Image', 'parskala' ),
			'set_featured_image'    => esc_html__( 'Set featured image', 'parskala' ),
			'remove_featured_image' => esc_html__( 'Remove featured image', 'parskala' ),
			'use_featured_image'    => esc_html__( 'Use as featured image', 'parskala' ),
			'insert_into_item'      => esc_html__( 'Add to story', 'parskala' ),
			'uploaded_to_this_item' => esc_html__( 'Uploaded to this story', 'parskala' ),
			'items_list'            => esc_html__( 'Stories list', 'parskala' ),
			'items_list_navigation' => esc_html__( 'Stories list navigation', 'parskala' ),
			'filter_items_list'     => esc_html__( 'Filter stories list', 'parskala' ),
		);

		$args = array(
			'label'               => esc_html__( 'Story', 'parskala' ),
			'description'         => '',
			'labels'              => $labels,
			'menu_icon'           => parskala_IMG . 'icon/instagram.svg',
			'supports'            => array( 'title', 'thumbnail', 'author' ),
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'hierarchical'        => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'rest_base'           => 'prk-story-api',
		);

		register_post_type( 'prk-story', $args );
	}

	/**
	 * Create story box post type.
	 * post_type = prk-story-box
	 *
	 * @since 1.0.0
	 */
	public function create_story_box_post_type() {
		$labels = array(
			'name'                  => esc_html_x( 'باکس های استوری', 'Post Type General Name', 'parskala' ),
			'singular_name'         => esc_html_x( 'Story Box', 'Post Type Singular Name', 'parskala' ),
			'menu_name'             => esc_html_x( 'باکس های استوری', 'Admin Menu text', 'parskala' ),
			'name_admin_bar'        => esc_html__( 'Story Box', 'Add New on Toolbar', 'parskala' ),
			'archives'              => esc_html__( 'Story Box Archives', 'parskala' ),
			'attributes'            => esc_html__( 'Story Box Attributes', 'parskala' ),
			'parent_item_colon'     => esc_html__( 'Parent Story Box:', 'parskala' ),
			'all_items'             => esc_html__( 'All Stories Boxes', 'parskala' ),
			'add_new_item'          => esc_html__( 'Add New Story Box', 'parskala' ),
			'add_new'               => esc_html__( 'Add New', 'parskala' ),
			'new_item'              => esc_html__( 'New Story Box', 'parskala' ),
			'edit_item'             => esc_html__( 'Edit Story Box', 'parskala' ),
			'update_item'           => esc_html__( 'Update Story Box', 'parskala' ),
			'view_item'             => esc_html__( 'View Story Box', 'parskala' ),
			'view_items'            => esc_html__( 'View Stories Boxes', 'parskala' ),
			'search_items'          => esc_html__( 'Search Story Box', 'parskala' ),
			'not_found'             => esc_html__( 'Not found', 'parskala' ),
			'not_found_in_trash'    => esc_html__( 'Not found in trash', 'parskala' ),
			'featured_image'        => esc_html__( 'Featured Image', 'parskala' ),
			'set_featured_image'    => esc_html__( 'Set featured image', 'parskala' ),
			'remove_featured_image' => esc_html__( 'Remove featured image', 'parskala' ),
			'use_featured_image'    => esc_html__( 'Use as featured image', 'parskala' ),
			'insert_into_item'      => esc_html__( 'Add to story box', 'parskala' ),
			'uploaded_to_this_item' => esc_html__( 'Uploaded to this story box', 'parskala' ),
			'items_list'            => esc_html__( 'Story boxes list', 'parskala' ),
			'items_list_navigation' => esc_html__( 'Story boxes list navigation', 'parskala' ),
			'filter_items_list'     => esc_html__( 'Filter story boxes list', 'parskala' ),
		);

		$args = array(
			'label'               => esc_html__( 'باکس های استوری', 'parskala' ),
			'description'         => '',
			'labels'              => $labels,
			'menu_icon'           => '',
			'supports'            => array( 'title' ),
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'menu_position'       => 5,
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'hierarchical'        => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'rest_base'           => 'prk-story-box-api',
		);

		register_post_type( 'prk-story-box', $args );
	}


	/**
	 * Print custom scripts.
	 */
	public function print_scripts() {
		$screen = get_current_screen();

		if ( ! isset( $screen->id ) ) {
			return;
		}

		if ( in_array( $screen->id, array( 'prkstory-user', 'prkstory-public', 'prkstory-report', 'prk-story-box' ) ) ) {
			ob_start();
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('#menu-posts-prk-story').addClass('wp-has-current-submenu wp-menu-open menu-top menu-top-first').removeClass('wp-not-current-submenu');
					$('#menu-posts-prk-story > a').addClass('wp-has-current-submenu').removeClass('wp-not-current-submenu');
				});
			</script>
			<?php
			echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput
		}

		if ( 'prk-story-box' === $screen->id ) {
			ob_start();
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('a[href$="edit.php?post_type=prk-story-box"]').parent().addClass('current');
					$('a[href$="edit.php?post_type=prk-story-box"]').addClass('current');
				});
			</script>
			<?php
			echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput
		}


		if ( 'prkstory-user' === $screen->id ) {
			ob_start();
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('a[href$="edit.php?post_type=prkstory-user"]').parent().addClass('current');
					$('a[href$="edit.php?post_type=prkstory-user"]').addClass('current');
				});
			</script>
			<?php
			echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput
		}

		if ( 'prkstory-public' === $screen->id ) {
			ob_start();
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('a[href$="edit.php?post_type=prkstory-public"]').parent().addClass('current');
					$('a[href$="edit.php?post_type=prkstory-public"]').addClass('current');
				});
			</script>
			<?php
			echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput
		}

		if ( 'prkstory-public' === $screen->id ) {
			ob_start();
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('a[href$="edit.php?post_type=prkstory-public"]').parent().addClass('current');
					$('a[href$="edit.php?post_type=prkstory-public"]').addClass('current');
				});
			</script>
			<?php
			echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput
		}

		if ( 'prkstory-report' === $screen->id ) {
			ob_start();
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('a[href$="edit.php?post_type=prkstory-report"]').parent().addClass('current');
					$('a[href$="edit.php?post_type=prkstory-report"]').addClass('current');
				});
			</script>
			<?php
			echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput
		}
	}
}

new Prkstory_Post_Types();
