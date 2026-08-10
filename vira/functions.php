<?php
/**
 * Vira Theme Bootstrapper & Main Framework Loader
 *
 * @package Vira
 * @author  Vira Team
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Direct access not allowed.
}

// 1. Define Primary Vira Constants
define( 'VIRA_THEME_VERSION', '1.0.0' );
define( 'VIRA_THEME_DIR', get_template_directory() );
define( 'VIRA_THEME_URI', get_template_directory_uri() );

// 2. Define Compatibility Constants (prevents broken relative URLs in legacy templates)
if ( ! defined( 'parskala_URI' ) ) {
    define( 'parskala_URI', get_template_directory_uri() );
}
if ( ! defined( 'parskala_TEMPLATEPATH' ) ) {
    define( 'parskala_TEMPLATEPATH', get_template_directory() );
}
if ( ! defined( 'PARSKALA_INC_TEMPLATEPATH' ) ) {
    define( 'PARSKALA_INC_TEMPLATEPATH', get_template_directory() . '/inc' );
}
if ( ! defined( 'PRK_VERSION' ) ) {
    define( 'PRK_VERSION', '1.0.0' );
}
if ( ! defined( 'THEME_TEXTDOMAIN' ) ) {
    define( 'THEME_TEXTDOMAIN', 'vira' );
}

// 3. Load Vira Central Initialization & Dependency Engine
require_once VIRA_THEME_DIR . '/inc/class-vira-init.php';

// 4. Load Core E-Commerce Open-Source Engine Files
$vira_core_files = array(
    '/inc/options_includes.php',
    '/inc/vira_enqueue_script.php',
    '/inc/includes/mob_cheker.php',
    '/inc/includes/option_to_functions.php',
    '/inc/includes/prk_actions.php',
    '/inc/includes/prk-woo-actions.php',
    '/inc/includes/jdfs.php',
    '/inc/includes/breadcrumbs.php',
    '/inc/includes/mega-menu-prk.php',
    '/inc/includes/menu-options.php',
    '/inc/includes/search_product.php',
    '/inc/includes/set-location-Cookie.php',
    '/inc/includes/view_product.php',
    '/inc/includes/price-chart-pro.php',
    '/inc/includes/product_price_chart.php',
    '/inc/vira-theme-footers.php',
    '/inc/widgets.php',
    '/inc/vira-my-functions.php',
);

foreach ( $vira_core_files as $core_file ) {
    if ( file_exists( VIRA_THEME_DIR . $core_file ) ) {
        require_once VIRA_THEME_DIR . $core_file;
    }
}

/**
 * Custom Vira Theme Setup
 */
function vira_theme_setup() {
    load_theme_textdomain( 'vira', VIRA_THEME_DIR . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    register_nav_menus( array(
        'vira_header_menu' => 'منوی اصلی هدر ویرا',
        'vira_mobile_nav'  => 'منوی پایینی موبایل ویرا',
        'vira_footer_menu' => 'منوی فوتر ویرا',
    ) );
}
add_action( 'after_setup_theme', 'vira_theme_setup', 5 );

/**
 * Add Custom Vira E-Commerce Welcome Widget in WordPress Admin Dashboard
 */
function vira_add_admin_dashboard_widget() {
    wp_add_dashboard_widget(
        'vira_dashboard_status_widget',
        'وضعیت پلتفرم فروشگاهی ویرا (Vira Engine)',
        function() {
            ?>
            <div style="direction: rtl; text-align: right; font-family: Tahoma, Arial, sans-serif;">
                <div style="background: #ef394e; color: #fff; padding: 12px 16px; border-radius: 8px; margin-bottom: 12px; font-weight: bold;">
                    پلتفرم ویرا (Vira Framework v1.0.0) فعال است
                </div>
                <p>تمامی ۲۰ ماژول اختصاصی ویرا و قابلیت‌های بومی به طور کامل بارگذاری شده‌اند.</p>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=vira-admin-dashboard' ) ); ?>" class="button button-primary" style="background: #ef394e; border-color: #d62d41;">
                    ورود به مرکز فرماندهی ماژول‌ها
                </a>
            </div>
            <?php
        }
    );
}
add_action( 'wp_dashboard_setup', 'vira_add_admin_dashboard_widget' );
