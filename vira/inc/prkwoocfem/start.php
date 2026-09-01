<?php

define('PRKWOOCFEM_TOKEN', 'prkwoocfem');
define('PRKWOOCFEM_VERSION', '2.2.15');
define('PRKWOOCFEM_FILE', __FILE__);
define('PRKWOOCFEM_EMPTY_LABEL', 'prkwoocfem_empty_label');
define('PRKWOOCFEM_ORDER_META_KEY', '_prkwoocfem_order_meta_key');// use _ not show in backend
define('PRKWOOCFEM_FIELDS_KEY', 'prkwoocfem_fields');
define('PRKWOOCFEM_URL',get_template_directory_uri()."/inc/prkwoocfem/");
define('PRKWOOCFEM_INCLUDES',get_template_directory_uri()."/inc/prkwoocfem");

require_once(realpath(__DIR__) . DIRECTORY_SEPARATOR . 'includes/helpers.php');

if (!function_exists('prkwoocfem_init')) {

    function prkwoocfem_init()
    {
        $plugin_rel_path = basename(dirname(__FILE__)) . '/languages'; /* Relative to WP_PLUGIN_DIR */
        load_plugin_textdomain('checkout-field-editor-and-manager-for-woocommerce', false, $plugin_rel_path);
    }

}

if (!function_exists('prkwoocfem_autoloader')) {

    function prkwoocfem_autoloader($class_name)
    {
        if (0 === strpos($class_name, 'PRKWOOCFEM')) {
            $classes_dir = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;
            $class_file = 'class-' . str_replace('_', '-', strtolower($class_name)) . '.php';
            require_once $classes_dir . $class_file;
        }
    }

}

if (!function_exists('PRKWOOCFEM')) {

    function PRKWOOCFEM()
    {
        $instance = PRKWOOCFEM_Backend::instance(__FILE__, PRKWOOCFEM_VERSION);
        return $instance;
    }

}
add_action('plugins_loaded', 'prkwoocfem_init');
spl_autoload_register('prkwoocfem_autoloader');
if (is_admin()) {
    PRKWOOCFEM();
}
new PRKWOOCFEM_Api();

new PRKWOOCFEM_Front_End(__FILE__, PRKWOOCFEM_VERSION);


add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

add_action('prk_woo_checkout_custom_fields','prk_woo_checkout_custom_fields');

function prk_woo_checkout_custom_fields(){
    // var_dump($_POST);
    // die;
    PRKWOOCFEM_Backend::view('admin-root', []);
}


// function mind_defer_scripts( $tag, $handle, $src ) {
//     $defer = array( 
//       'prkwoocfem-backend',
//       'script'
//     );
//     if ( in_array( $handle, $defer ) ) {
//        return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
//     }
      
//       return $tag;
//   } 
//   add_filter( 'script_loader_tag', 'mind_defer_scripts', 10, 3 );