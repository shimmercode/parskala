<?php
/**
 * Vira central loader.
 *
 * @package Vira
 */

namespace Vira;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Init {
	private static $instance = null;
	private $active_modules  = array();

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'after_setup_theme', array( $this, 'load_core_files' ), 10 );
		add_action( 'init', array( $this, 'register_modules' ), 20 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ), 5 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ), 20 );
	}

	public function load_core_files() {
		$files = array(
			'/inc/helpers.php',
			'/inc/sms/class-vira-sms.php',
			'/inc/class-vira-pdf.php',
			'/inc/auth/auth.php',
			'/inc/auth/PRK_OTP_Firewall.php',
			'/inc/woo-quick-view/classes/class.backend.php',
			'/inc/woocommerce-group-attributes/includes/class-woocommerce-group-attributes.php',
			'/inc/prkwoocfem/includes/class-prkwoocfem-front-end.php',
			'/inc/notify-product-activity/notify-product-activity.php',
			'/inc/admin/class-vira-checkout-fields.php',
			'/inc/admin/class-vira-admin.php',
			'/inc/ajax/class-vira-ajax.php',
			'/inc/integrations/class-vira-core-engine.php',
			'/inc/integrations/class-vira-woo.php',
			'/inc/includes/set-location-Cookie.php',
		);
		foreach ( $files as $rel ) {
			Loader::require_file( $rel );
		}
		// Global class (no namespace) — must use leading backslash from this namespace.
		Loader::boot( '\\Vira_Checkout_Fields_Admin', 'init' );
	}

	public function register_modules() {
		$dir         = get_template_directory() . '/inc/modules/';
		$woo_active  = class_exists( 'WooCommerce' );
		$modules_map = array(
			'vira-location-selector' => array( 'class' => 'Location_Selector\\Controller', 'dep' => 'core' ),
			'vira-tax-invoice'       => array( 'class' => 'Tax_Invoice\\Controller', 'dep' => 'woo' ),
			'vira-price-chart'       => array( 'class' => 'Price_Chart\\Controller', 'dep' => 'woo' ),
			'vira-product-stories'   => array( 'class' => 'Product_Stories\\Controller', 'dep' => 'core' ),
			'vira-trust-modals'      => array( 'class' => 'Trust_Modals\\Controller', 'dep' => 'woo' ),
			'vira-guest-tracking'    => array( 'class' => 'Guest_Tracking\\Controller', 'dep' => 'woo' ),
			'vira-loyalty-rewards'   => array( 'class' => 'Loyalty_Rewards\\Controller', 'dep' => 'woo' ),
			'vira-next-shopping'     => array( 'class' => 'Next_Shopping\\Controller', 'dep' => 'woo' ),
			'vira-size-guide'        => array( 'class' => 'Size_Guide\\Controller', 'dep' => 'woo' ),
			'01-smart-search'        => array( 'class' => 'Smart_Search\\Controller', 'dep' => 'woo' ),
			'02-bottom-nav'          => array( 'class' => 'Bottom_Nav\\Controller', 'dep' => 'core' ),
			'03-ajax-filter'         => array( 'class' => 'Ajax_Filter\\Controller', 'dep' => 'woo' ),
			'04-product-card'        => array( 'class' => 'Product_Card\\Controller', 'dep' => 'woo' ),
			'05-free-shipping'       => array( 'class' => 'Free_Shipping\\Controller', 'dep' => 'woo' ),
			'06-installment-calc'    => array( 'class' => 'Installment_Calc\\Controller', 'dep' => 'woo' ),
			'07-sticky-cart'         => array( 'class' => 'Sticky_Cart\\Controller', 'dep' => 'woo' ),
			'08-instant-buy'         => array( 'class' => 'Instant_Buy\\Controller', 'dep' => 'woo' ),
			'09-vendor-shield'       => array( 'class' => 'Vendor_Shield\\Controller', 'dep' => 'woo' ),
			'10-bundle-discount'     => array( 'class' => 'Bundle_Discount\\Controller', 'dep' => 'woo' ),
			'11-stock-timer'         => array( 'class' => 'Stock_Timer\\Controller', 'dep' => 'woo' ),
			'12-media-reviews'       => array( 'class' => 'Media_Reviews\\Controller', 'dep' => 'woo' ),
			'13-diff-compare'        => array( 'class' => 'Diff_Compare\\Controller', 'dep' => 'woo' ),
			'14-ai-recommend'        => array( 'class' => 'AI_Recommend\\Controller', 'dep' => 'woo' ),
			'15-price-alert'         => array( 'class' => 'Price_Alert\\Controller', 'dep' => 'woo' ),
			'16-iran-checkout'       => array( 'class' => 'Iran_Checkout\\Controller', 'dep' => 'woo' ),
			'17-map-address'         => array( 'class' => 'Map_Address\\Controller', 'dep' => 'woo' ),
			'18-tiered-pricing'      => array( 'class' => 'Tiered_Pricing\\Controller', 'dep' => 'woo' ),
			'19-seo-schema'          => array( 'class' => 'SEO_Schema\\Controller', 'dep' => 'woo' ),
			'20-otp-sms'             => array( 'class' => 'OTP_SMS\\Controller', 'dep' => 'core' ),
		);

		foreach ( $modules_map as $slug => $config ) {
			if ( 'woo' === $config['dep'] && ! $woo_active ) {
				continue;
			}
			if ( ! function_exists( 'vira_is_module_enabled' ) || ! vira_is_module_enabled( $slug, true ) ) {
				continue;
			}
			$file_path = $dir . $slug . '/class-controller.php';
			if ( ! file_exists( $file_path ) ) {
				continue;
			}
			require_once $file_path;
			$class_full = '\Vira\Modules\\' . $config['class'];
			if ( class_exists( $class_full ) && method_exists( $class_full, 'init' ) ) {
				$class_full::init();
				$this->active_modules[] = $slug;
			}
		}
	}

	public function enqueue_frontend_assets() {
		$uri = get_template_directory_uri();
		$ver = VIRA_THEME_VERSION;
		$dir = get_template_directory();

		$styles = array(
			'vira-remixicon'     => '/assets/fonts/ri-fonts/remixicon.css',
			'vira-flaticon'      => '/assets/fonts/font/flaticon.css',
			'vira-iconsax'       => '/assets/fonts/parsfont/style.css',
			'vira-general'       => '/assets/css/general.css',
			'vira-menu'          => '/assets/css/vira-menu.css',
			'vira-classic-style' => '/assets/css/3.vira-classic.css',
			'vira-mobile-style'  => '/assets/css/vira-mobile.css',
			'vira-core-css'      => '/assets/css/vira-core.css',
			'vira-card-css'      => '/assets/css/vira-card.css',
			'vira-bottom-nav-css'=> '/assets/css/vira-bottom-nav.css',
			'vira-modals-css'    => '/assets/css/vira-modals.css',
		);
		foreach ( $styles as $handle => $rel ) {
			if ( file_exists( $dir . $rel ) ) {
				wp_enqueue_style( $handle, $uri . $rel, array(), $ver );
			}
		}
		wp_enqueue_style( 'vira-style', get_stylesheet_uri(), array(), $ver );

		$scripts = array(
			'vira-owl-js'    => '/assets/js/owl.carousel.min.js',
			'vira-core-js'   => '/assets/js/vira-core.js',
			'vira-modals-js' => '/assets/js/vira-modals.js',
			'vira-checkout-js'=> '/assets/js/vira-checkout.js',
		);
		foreach ( $scripts as $handle => $rel ) {
			if ( file_exists( $dir . $rel ) ) {
				wp_enqueue_script( $handle, $uri . $rel, array( 'jquery' ), $ver, true );
			}
		}

		$mod_js = '/assets/js/vira-modules.js';
		if ( file_exists( $dir . $mod_js ) ) {
			wp_enqueue_script( 'vira-modules-js', $uri . $mod_js, array( 'jquery' ), $ver, true );
		}

		$localize_handle = wp_script_is( 'vira-core-js', 'enqueued' ) ? 'vira-core-js' : ( wp_script_is( 'vira-modules-js', 'enqueued' ) ? 'vira-modules-js' : '' );
		if ( $localize_handle ) {
			wp_localize_script(
				$localize_handle,
				'viraVars',
				array(
					'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( 'vira_ajax_nonce' ),
					'location' => function_exists( 'vira_get_user_location' ) ? vira_get_user_location() : array(),
					'tomanStr' => 'تومان',
					'isLogged' => is_user_logged_in(),
				)
			);
		}
	}

	public function enqueue_admin_assets( $hook ) {
		if ( 'toplevel_page_vira-admin-dashboard' === $hook ) {
			$rel = '/assets/css/vira-admin.css';
			if ( file_exists( get_template_directory() . $rel ) ) {
				wp_enqueue_style( 'vira-admin-css', get_template_directory_uri() . $rel, array(), VIRA_THEME_VERSION );
			}
		}
	}

	public function get_active_modules() {
		return $this->active_modules;
	}
}

Init::get_instance();
