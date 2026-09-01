<?php



/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WooCommerce_Group_Attributes
 * @subpackage WooCommerce_Group_Attributes/admin
 * @author     parskala
 */
class WooCommerce_Group_Attributes_Admin extends WooCommerce_Group_Attributes  {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	protected $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function load_redux(){
	    // Load the theme/plugin options
	    if ( file_exists( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/options-init.php' ) ) {
	        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/options-init.php';
	    }
	}

    /**
     * Enqueue Admin Styles
     * @return  boolean
     */
    public function enqueue_styles()
    {
        $screen = get_current_screen();
        if ( $screen->post_type != 'attribute_group' ) {
            return;
        }
        wp_enqueue_style($this->plugin_name.'-select2', WCGROUPATTRIBUTES_DIR.'admin/css/select2.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name.'-select2-sortable', WCGROUPATTRIBUTES_DIR.'admin/css/select2.sortable.css', array(), $this->version, 'all');
    }

    /**
     * Enqueue Admin Scripts
     * @return  boolean
     */
    public function enqueue_scripts()
    {
    	wp_enqueue_media();

        global $woocommerce;
        if( version_compare( $woocommerce->version, '3.6', ">=" ) ) {
            wp_enqueue_script($this->plugin_name.'-admin', WCGROUPATTRIBUTES_DIR.'admin/js/woocommerce-group-attributes-admin.js', array('jquery'), $this->version, true);
        } else {
            wp_enqueue_script($this->plugin_name.'-admin', WCGROUPATTRIBUTES_DIR.'admin/js/woocommerce-group-attributes-admin-old.js', array('jquery'), $this->version, true);
        }

        $screen = get_current_screen();
        if ( $screen->post_type != 'attribute_group' ) {
            return;
        }
        wp_enqueue_script($this->plugin_name.'-select2', WCGROUPATTRIBUTES_DIR.'admin/js/select2.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name.'-select2-sortable', WCGROUPATTRIBUTES_DIR.'admin/js/select2.sortable.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name.'-html5-sortable', WCGROUPATTRIBUTES_DIR.'admin/js/html.sortable.min.js', array('jquery'), $this->version, true);
    }

    /**
     * Add admin JS vars
     * @return  boolean
     */
    public function add_admin_js_vars()
    {
    ?>
    <script type='text/javascript'>
        var woocommerce_group_attribute_settings = <?php echo json_encode(array(
            'ajax_url' => admin_url('admin-ajax.php')
        )); ?>
    </script>
    <?php
    }
}