<?php

namespace Prkstory;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Story widget for Elementor.
 *
 * @since 1.2.0
 */
class Prkstory_Elementor_Widget_Loader {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @return Plugin An instance of the class.
	 * @since 1.2.0
	 * @access public
	 *
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {
		if ( 'elementor' === PRKSTORY()->script_mode() ) {
			add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_scripts' ) );
		}

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'elementor/widgets/class-prkstory-elementor-widget.php';
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		$this->include_widgets_files();
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Prkstory_Elementor_Widget() );
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {
		wp_register_style( 'prk-story', plugin_dir_url( dirname( __DIR__ ) ) . 'public/css/prk-story.min.css', array(), PRKSTORY_VERSION, false );
		wp_register_script( 'prk-story', plugin_dir_url( dirname( __DIR__ ) ) . 'public/js/prk-story.min.js', array( 'jquery' ), PRKSTORY_VERSION, false );
		wp_localize_script( 'prk-story', 'prkStoryObject', PRKSTORY()->story_strings() );
	}
}

// Fire class!
Prkstory_Elementor_Widget_Loader::instance();