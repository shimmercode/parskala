<?php
/**
 * Vira Theme Central Module & Dependency Manager (Rule #24)
 *
 * @package Vira
 * @since   1.0.0
 */

namespace Vira;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Direct access not allowed.
}

class Init {
    /**
     * Singleton instance.
     *
     * @var Init|null
     */
    private static $instance = null;

    /**
     * Active module list.
     *
     * @var array
     */
    private $active_modules = array();

    /**
     * Get singleton instance.
     *
     * @return Init
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor.
     */
    private function __construct() {
        add_action( 'after_setup_theme', array( $this, 'load_core_files' ), 10 );
        add_action( 'init', array( $this, 'register_modules' ), 20 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ), 5 );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ), 20 );
    }

    /**
     * Load core helpers and integrations.
     */
    public function load_core_files() {
        $dir = get_template_directory();

        // 1. Helpers
        require_once $dir . '/inc/helpers.php';

        // 2. Admin Control Center (M20)
        require_once $dir . '/inc/admin/class-vira-admin.php';

        // 3. AJAX Controller
        require_once $dir . '/inc/ajax/class-vira-ajax.php';

        // 4. Base Integrations
        require_once $dir . '/inc/integrations/class-vira-core-engine.php';
        require_once $dir . '/inc/integrations/class-vira-woo.php';
        require_once $dir . '/inc/integrations/class-vira-dokan.php';
    }

    /**
     * Register and initialize enabled modules (Rule #24: Dependency checking).
     */
    public function register_modules() {
        $dir = get_template_directory() . '/inc/modules/';

        // Module Map: slug => array( class, dependencies )
        $modules_map = array(
            // 1. Vira Base E-Commerce Modules (Iranian market native modules)
            'vira-location-selector' => array( 'class' => 'Location_Selector\\Controller',  'dep' => 'woo' ),
            'vira-tax-invoice'       => array( 'class' => 'Tax_Invoice\\Controller',        'dep' => 'woo' ),
            'vira-price-chart'       => array( 'class' => 'Price_Chart\\Controller',        'dep' => 'woo' ),
            'vira-product-stories'   => array( 'class' => 'Product_Stories\\Controller',    'dep' => 'core' ),
            'vira-trust-modals'      => array( 'class' => 'Trust_Modals\\Controller',       'dep' => 'woo' ),
            'vira-guest-tracking'    => array( 'class' => 'Guest_Tracking\\Controller',     'dep' => 'woo' ),
            'vira-loyalty-rewards'   => array( 'class' => 'Loyalty_Rewards\\Controller',    'dep' => 'woo' ),
            'vira-next-shopping'     => array( 'class' => 'Next_Shopping\\Controller',      'dep' => 'woo' ),
            'vira-size-guide'        => array( 'class' => 'Size_Guide\\Controller',         'dep' => 'woo' ),

            // 2. Vira 20 Exclusive Next-Gen Modules (M01 to M19 - M20 is in Admin)
            '01-smart-search'        => array( 'class' => 'Smart_Search\\Controller',       'dep' => 'woo' ),
            '02-bottom-nav'          => array( 'class' => 'Bottom_Nav\\Controller',         'dep' => 'core' ),
            '03-ajax-filter'         => array( 'class' => 'Ajax_Filter\\Controller',        'dep' => 'woo' ),
            '04-product-card'        => array( 'class' => 'Product_Card\\Controller',       'dep' => 'woo' ),
            '05-free-shipping'       => array( 'class' => 'Free_Shipping\\Controller',      'dep' => 'woo' ),
            '06-installment-calc'    => array( 'class' => 'Installment_Calc\\Controller',   'dep' => 'woo' ),
            '07-sticky-cart'         => array( 'class' => 'Sticky_Cart\\Controller',        'dep' => 'woo' ),
            '08-instant-buy'         => array( 'class' => 'Instant_Buy\\Controller',        'dep' => 'woo' ),
            '09-vendor-shield'       => array( 'class' => 'Vendor_Shield\\Controller',      'dep' => 'woo' ),
            '10-bundle-discount'     => array( 'class' => 'Bundle_Discount\\Controller',    'dep' => 'woo' ),
            '11-stock-timer'         => array( 'class' => 'Stock_Timer\\Controller',        'dep' => 'woo' ),
            '12-media-reviews'       => array( 'class' => 'Media_Reviews\\Controller',      'dep' => 'woo' ),
            '13-diff-compare'        => array( 'class' => 'Diff_Compare\\Controller',       'dep' => 'woo' ),
            '14-ai-recommend'        => array( 'class' => 'AI_Recommend\\Controller',       'dep' => 'woo' ),
            '15-price-alert'         => array( 'class' => 'Price_Alert\\Controller',        'dep' => 'woo' ),
            '16-iran-checkout'       => array( 'class' => 'Iran_Checkout\\Controller',      'dep' => 'woo' ),
            '17-map-address'         => array( 'class' => 'Map_Address\\Controller',        'dep' => 'woo' ),
            '18-tiered-pricing'      => array( 'class' => 'Tiered_Pricing\\Controller',     'dep' => 'woo' ),
            '19-seo-schema'          => array( 'class' => 'SEO_Schema\\Controller',         'dep' => 'woo' ),
            '20-otp-sms'             => array( 'class' => 'OTP_SMS\\Controller',            'dep' => 'core' ),
        );

        $woo_active = class_exists( 'WooCommerce' );

        foreach ( $modules_map as $slug => $config ) {
            if ( 'woo' === $config['dep'] && ! $woo_active ) {
                continue;
            }

            if ( ! vira_is_module_enabled( $slug, true ) ) {
                continue;
            }

            $file_path = $dir . $slug . '/class-controller.php';
            if ( file_exists( $file_path ) ) {
                require_once $file_path;
                $class_full = '\\Vira\\Modules\\' . $config['class'];
                if ( class_exists( $class_full ) && method_exists( $class_full, 'init' ) ) {
                    $class_full::init();
                    $this->active_modules[] = $slug;
                }
            }
        }
    }

    /**
     * Enqueue complete frontend styles & scripts (Base E-Commerce Engine + Vira Custom).
     */
    public function enqueue_frontend_assets() {
        $uri = get_template_directory_uri();
        $ver = '1.0.0';

        // 1. Icon & Font Stylesheets
        wp_enqueue_style( 'vira-remixicon', $uri . '/assets/fonts/ri-fonts/remixicon.css', array(), $ver );
        wp_enqueue_style( 'vira-flaticon', $uri . '/assets/fonts/font/flaticon.css', array(), $ver );
        wp_enqueue_style( 'vira-iconsax', $uri . '/assets/fonts/parsfont/style.css', array(), $ver );

        // 2. Main E-Commerce Engine & Layout Stylesheets
        wp_enqueue_style( 'vira-general', $uri . '/assets/css/general.css', array(), $ver );
        wp_enqueue_style( 'vira-menu', $uri . '/assets/css/vira-menu.css', array( 'vira-general' ), $ver );
        wp_enqueue_style( 'vira-account-header', $uri . '/assets/css/vira-account-header.css', array( 'vira-general' ), $ver );
        wp_enqueue_style( 'vira-classic-style', $uri . '/assets/css/3.vira-classic.css', array( 'vira-general' ), $ver );
        wp_enqueue_style( 'vira-mobile-style', $uri . '/assets/css/vira-mobile.css', array( 'vira-general' ), $ver );

        // 3. Carousel & Slider Stylesheets
        wp_enqueue_style( 'vira-swiper', $uri . '/assets/css/lunches/swiper.css', array(), $ver );
        wp_enqueue_style( 'vira-swiper-slider', $uri . '/assets/css/lunches/swiper-slider.css', array( 'vira-swiper' ), $ver );
        wp_enqueue_style( 'vira-owl-carousel', $uri . '/assets/css/carousels/owl.carousel.min.css', array(), $ver );
        wp_enqueue_style( 'vira-owl-items', $uri . '/assets/css/carousels/owl.carousel-items.css', array( 'vira-owl-carousel' ), $ver );
        wp_enqueue_style( 'vira-modal-engine', $uri . '/assets/css/lunches/modal.css', array(), $ver );

        // 4. Vira Next-Gen Custom Component Stylesheets
        wp_enqueue_style( 'vira-core-css', $uri . '/assets/css/vira-core.css', array( 'vira-classic-style' ), $ver );
        wp_enqueue_style( 'vira-card-css', $uri . '/assets/css/vira-card.css', array( 'vira-core-css' ), $ver );
        wp_enqueue_style( 'vira-bottom-nav-css', $uri . '/assets/css/vira-bottom-nav.css', array( 'vira-core-css' ), $ver );
        wp_enqueue_style( 'vira-modals-css', $uri . '/assets/css/vira-modals.css', array( 'vira-core-css' ), $ver );

        // 5. Core E-Commerce JavaScript Libraries & Scripts
        wp_enqueue_script( 'vira-popper', $uri . '/assets/js/popper.min.js', array( 'jquery' ), $ver, true );
        wp_enqueue_script( 'vira-owl-js', $uri . '/assets/js/owl.carousel.min.js', array( 'jquery' ), $ver, true );
        wp_enqueue_script( 'vira-swiper-js', $uri . '/assets/js/swiper.js', array( 'jquery' ), $ver, true );
        wp_enqueue_script( 'vira-simplebar', $uri . '/assets/js/simplebar.min.js', array( 'jquery' ), $ver, true );
        if ( file_exists( get_template_directory() . '/assets/js/custom.js' ) ) {
            wp_enqueue_script( 'vira-custom-engine-js', $uri . '/assets/js/custom.js', array( 'jquery', 'vira-owl-js' ), $ver, true );
        }

        // 6. Vira Custom Handlers
        wp_enqueue_script( 'vira-core-js', $uri . '/assets/js/vira-core.js', array( 'jquery' ), $ver, true );
        wp_enqueue_script( 'vira-modals-js', $uri . '/assets/js/vira-modals.js', array( 'vira-core-js' ), $ver, true );
        wp_enqueue_script( 'vira-checkout-js', $uri . '/assets/js/vira-checkout.js', array( 'vira-core-js' ), $ver, true );

        wp_localize_script( 'vira-core-js', 'viraVars', array(
            'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
            'nonce'     => wp_create_nonce( 'vira_ajax_nonce' ),
            'location'  => vira_get_user_location(),
            'tomanStr'  => 'تومان',
            'isLogged'  => is_user_logged_in(),
        ) );
    }

    /**
     * Enqueue admin dashboard styles for Vira Control Center.
     */
    public function enqueue_admin_assets( $hook ) {
        if ( 'toplevel_page_vira-admin-dashboard' === $hook ) {
            $uri = get_template_directory_uri();
            wp_enqueue_style( 'vira-admin-css', $uri . '/assets/css/vira-admin.css', array(), '1.0.0' );
        }
    }

    /**
     * Get active modules list.
     *
     * @return array
     */
    public function get_active_modules() {
        return $this->active_modules;
    }
}

Init::get_instance();
