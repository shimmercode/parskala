<?php
/**
 * Vira Theme Bootstrap — safe loader (no early admin APIs, no Dokan, no ionCube).
 *
 * @package Vira
 * @since   1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VIRA_THEME_VERSION', '1.0.2' );
define( 'VIRA_THEME_DIR', get_template_directory() );
define( 'VIRA_THEME_URI', get_template_directory_uri() );

if ( ! defined( 'parskala_URI' ) ) {
	define( 'parskala_URI', VIRA_THEME_URI );
}
if ( ! defined( 'parskala_TEMPLATEPATH' ) ) {
	define( 'parskala_TEMPLATEPATH', VIRA_THEME_DIR );
}
if ( ! defined( 'PARSKALA_INC_TEMPLATEPATH' ) ) {
	define( 'PARSKALA_INC_TEMPLATEPATH', VIRA_THEME_DIR . '/inc' );
}
if ( ! defined( 'PRK_VERSION' ) ) {
	define( 'PRK_VERSION', VIRA_THEME_VERSION );
}
if ( ! defined( 'THEME_TEXTDOMAIN' ) ) {
	define( 'THEME_TEXTDOMAIN', 'vira' );
}

require_once VIRA_THEME_DIR . '/inc/class-vira-init.php';

/**
 * Theme supports.
 */
function vira_theme_setup() {
	load_theme_textdomain( 'vira', VIRA_THEME_DIR . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 240, 'flex-height' => true, 'flex-width' => true ) );

	register_nav_menus(
		array(
			'vira_header_menu' => 'منوی اصلی هدر ویرا',
			'vira_mobile_nav'  => 'منوی پایینی موبایل ویرا',
			'vira_footer_menu' => 'منوی فوتر ویرا',
		)
	);
}
add_action( 'after_setup_theme', 'vira_theme_setup', 5 );

function vira_widgets_init() {
	register_sidebar(
		array(
			'name'          => 'سایدبار فروشگاه ویرا',
			'id'            => 'vira-shop-sidebar',
			'before_widget' => '<section class="vira-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="vira-widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'vira_widgets_init' );

function vira_add_admin_dashboard_widget() {
	wp_add_dashboard_widget(
		'vira_dashboard_status_widget',
		'وضعیت پلتفرم فروشگاهی ویرا',
		function () {
			?>
			<div style="direction:rtl;text-align:right;font-family:Tahoma,Arial,sans-serif;">
				<div style="background:#ef394e;color:#fff;padding:12px 16px;border-radius:8px;margin-bottom:12px;font-weight:bold;">
					ویرا v<?php echo esc_html( VIRA_THEME_VERSION ); ?> فعال است — بدون دکان
				</div>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=vira-admin-dashboard' ) ); ?>" class="button button-primary">مرکز فرماندهی ماژول‌ها</a>
			</div>
			<?php
		}
	);
}
add_action( 'wp_dashboard_setup', 'vira_add_admin_dashboard_widget' );
