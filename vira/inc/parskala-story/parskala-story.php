<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
// //MrCode Market
// update_option( 'prk-story-license-notice', true );
// update_option( 'prk-story-purchase-code', 'a70831f6-5e91-42bf-b624-72be784080b7' );
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PRKSTORY_VERSION', '3.2.1' );



define( 'PRKSTORY_PATH', get_template_directory().'/inc/parskala-story/');
define( 'PRKSTORY_DIR', get_template_directory_uri().'/inc/parskala-story/' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-prk-story-activator.php
 */
function prkstory_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-parskala-story-activator.php';
	Prkstory_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-prk-story-deactivator.php
 */
function prkstory_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-parskala-story-deactivator.php';
	Prkstory_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'prkstory_activate' );
register_deactivation_hook( __FILE__, 'prkstory_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-prkstory.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function prkstory_run() {

	$plugin = new Prkstory();
	$plugin->run();

}

prkstory_run();
