<?php

/**
 * The plugin bootstrap file
 *
 *
 * @package           WooCommerce_Group_Attributes
 *
 * Description:       Want to group multiple attributes on your product page? Use this plugin!
 * Author:            parskala
 * Text Domain:       woocommerce-group-attributes
 * Domain Path:       /languages
 * WC tested up to:   4.2.2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WCGROUPATTRIBUTES_PATH', get_template_directory().'/inc/woocommerce-group-attributes/');
define( 'WCGROUPATTRIBUTES_DIR', get_template_directory_uri().'/inc/woocommerce-group-attributes/' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-group-attributes-activator.php
 */
function activate_WooCommerce_Group_Attributes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-group-attributes-activator.php';
	WooCommerce_Group_Attributes_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-group-attributes-deactivator.php
 */
function deactivate_WooCommerce_Group_Attributes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-group-attributes-deactivator.php';
	WooCommerce_Group_Attributes_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_WooCommerce_Group_Attributes' );
register_deactivation_hook( __FILE__, 'deactivate_WooCommerce_Group_Attributes' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-group-attributes.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_WooCommerce_Group_Attributes() {

	$plugin_data = get_plugin_data( __FILE__ );
	$version = $plugin_data['Version'];

	$plugin = new WooCommerce_Group_Attributes($version);
	$plugin->run();

	return $plugin;

}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce/woocommerce.php')){
	$WooCommerce_Group_Attributes = run_WooCommerce_Group_Attributes();
} else {
	add_action( 'admin_notices', 'WooCommerce_Group_Attributes_Not_Installed' );
}

function WooCommerce_Group_Attributes_Not_Installed()
{
	?>
    <div class="error">
      <p><?php _e( 'WooCommerce Group Attributes requires the WooCommerce Please install or activate them', 'woocommerce-group-attributes'); ?></p>
    </div>
    <?php
}