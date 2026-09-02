<?php



/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    WooCommerce_Group_Attributes
 * @subpackage WooCommerce_Group_Attributes/includes
 * @author     parskala
 */
class WooCommerce_Group_Attributes_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$loaded = load_theme_textdomain(
			'woocommerce-group-attributes',
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);


	}



}
