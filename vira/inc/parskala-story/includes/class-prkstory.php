<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Prkstory
 * @subpackage Prkstory/includes
 * @author     parskala <info@masirwp.com>
 */
class Prkstory {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Prkstory_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PRKSTORY_VERSION' ) ) {
			$this->version = PRKSTORY_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'prk-story';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Prkstory_Loader. Orchestrates the hooks of the plugin.
	 * - Prkstory_i18n. Defines internationalization functionality.
	 * - Prkstory_Admin. Defines all hooks for the admin area.
	 * - Prkstory_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * Dynamic contents class.
		 */
		require_once PRKSTORY_PATH . 'includes/class-prkstory-dynamic-contents.php';

		/**
		 * Helper Class
		 */
		require_once PRKSTORY_PATH . 'includes/class-prkstory-helpers.php';

		/**
		 * Creator Class
		 */
		require_once PRKSTORY_PATH . 'includes/class-prkstory-creator.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once PRKSTORY_PATH . 'includes/class-prk-story-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once PRKSTORY_PATH . 'includes/class-prk-story-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		if ( is_admin() ) {
			require_once PRKSTORY_PATH . 'admin/class-prkstory-admin.php';
		}

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once PRKSTORY_PATH . 'public/class-prkstory-public.php';

		/**
		 * Plugin framework
		 */
		// if ( ! class_exists( 'CSF' ) ) {
		// 	require_once PRKSTORY_PATH . 'lib/codestar-framework/codestar-framework.php';
		// }

		/**
		 * Submit class
		 */
		require_once PRKSTORY_PATH . 'includes/class-prkstory-submit.php';

		/**
		 * Modal more buttons.
		 */
		require_once PRKSTORY_PATH . 'includes/class-prkstory-more-buttons.php';

		$this->loader = new Prkstory_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Prkstory_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Prkstory_i18n();

		$plugin_i18n->load_plugin_textdomain();
		// $this->loader->add_action( 'plugins_loaded', $this, 'load_framework' );
		// $this->loader->add_action( 'plugins_loaded', $this, 'load_third_parties' );
		$this->load_framework();
		$this->load_third_parties();


	}

	/**
	 * Load framework config files
	 * Metabox & Plugin options
	 *
	 * @since 1.0.0
	 */
	public function load_framework() {
		/**
		 * Post types.
		 */
		require_once PRKSTORY_PATH . 'admin/class-prkstory-post-types.php';

		/**
		 * Metaboxes.
		 */
		require_once PRKSTORY_PATH . 'admin/metabox.php';


	}

	/**
	 * Integration with other themes and plugins.
	 *
	 * @sicne 1.2.0
	 */
	public function load_third_parties() {
		/**
		 * Elementor widget.
		 */
		if ( did_action( 'elementor/loaded' ) ) {
			require_once PRKSTORY_PATH . 'integrations/elementor/class-prkstory-elementor-widget-loader.php';
		}




		require_once PRKSTORY_PATH . 'integrations/blog/init.php';

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		if ( ! is_admin() ) {
			return;
		}

		$plugin_admin    = new Prkstory_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'create_admin_menu' );
		$this->loader->add_action( 'manage_prk-story-box_posts_columns', $plugin_admin, 'story_box_shortcode_column' );
		$this->loader->add_action( 'manage_prk-story-box_posts_custom_column', $plugin_admin, 'story_box_shortcode_column_content', 10, 2 );
		$this->loader->add_action( 'manage_prk-story-box_posts_custom_column', $plugin_admin, 'story_box_shortcode_column_content', 10, 2 );
		$this->loader->add_action( 'prkstory_before_item_delete', $plugin_admin, 'ajax_demo_blocker' );
		$this->loader->add_action( 'prkstory_before_story_delete', $plugin_admin, 'ajax_demo_blocker' );
		$this->loader->add_action( 'prkstory_before_story_submit', $plugin_admin, 'ajax_demo_blocker' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'settings_link' );
		$this->loader->add_action( 'csf_options_before', $plugin_admin, 'options_before_html' );
		$this->loader->add_action( 'csf_options_after', $plugin_admin, 'options_after_html' );
		$this->loader->add_action( 'wp_ajax_prkstory_video_metabox_handle', $plugin_admin, 'video_metabox_handle' );
		$this->loader->add_action( 'wp_ajax_prkstory_remove_notice', $plugin_admin, 'remove_notice' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Prkstory_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'rest_api_init', $plugin_public, 'rest_api' );
		$this->loader->add_action( 'rest_api_init', $plugin_public, 'author_rest_api' );
		$this->loader->add_shortcode( 'prkstory', $plugin_public, 'shortcode' );
		$this->loader->add_shortcode( 'prkstory-user-public-stories', $plugin_public, 'user_public_stories_shortcode' );
		$this->loader->add_shortcode( 'prkstory-user-single-stories', $plugin_public, 'user_single_stories_shortcode' );
		$this->loader->add_shortcode( 'prkstory-activities', $plugin_public, 'activities_shortcode' );
		$this->loader->add_shortcode( 'prk-story-merged-user-stories', $plugin_public, 'merged_user_stories_shortcode' );
		$this->loader->add_shortcode( 'prk-story-single-stories', $plugin_public, 'single_stories_shortcode' );
		$this->loader->add_shortcode( 'prk-story-public-stories', $plugin_public, 'public_stories_shortcode' );
		$this->loader->add_shortcode( 'prk-story-self-stories', $plugin_public, 'self_stories_shortcode' );

		// Deprecated shortcodes.
		$this->loader->add_shortcode( 'prk-story', $plugin_public, 'deprecated_shortcode' );
		$this->loader->add_shortcode( 'prk-story-user-stories', $plugin_public, 'user_stories_deprecated_shortcode' );
		$this->loader->add_shortcode( 'prk-story-user-single-stories', $plugin_public, 'user_single_stories_deprecated_shortcode' );
		$this->loader->add_shortcode( 'prk-story-activities', $plugin_public, 'activities_deprecated_shortcode' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Prkstory_Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version() {
		return $this->version;
	}

}
