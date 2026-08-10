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

define( 'VIRA_THEME_VERSION', '1.0.0' );
define( 'VIRA_THEME_DIR', get_template_directory() );
define( 'VIRA_THEME_URI', get_template_directory_uri() );

// Load Vira Central Initialization & Dependency Engine
require_once VIRA_THEME_DIR . '/inc/class-vira-init.php';

/**
 * Custom Vira Theme Setup
 */
function vira_theme_setup() {
    // Enable RTL and Persian localization
    load_theme_textdomain( 'vira', VIRA_THEME_DIR . '/languages' );

    // Theme support
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Register Persian Navigation Menus
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
                <p>تمامی ۲۰ ماژول اختصاصی ویرا و قابلیت‌های بومی پارس‌کالا با هسته وودمارت هماهنگ شده‌اند.</p>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=vira-admin-dashboard' ) ); ?>" class="button button-primary" style="background: #ef394e; border-color: #d62d41;">
                    ورود به مرکز فرماندهی ماژول‌ها
                </a>
            </div>
            <?php
        }
    );
}
add_action( 'wp_dashboard_setup', 'vira_add_admin_dashboard_widget' );
