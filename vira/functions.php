<?php
/**
 * Vira bootstrap — ParsKala 3.9.9 plaintext stack + Vira modules.
 * Original functions.php is ionCube; this file replaces it without encoding.
 *
 * @package Vira
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VIRA_THEME_VERSION', '1.6.0' );
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

require_once VIRA_THEME_DIR . '/inc/helpers.php';
require_once VIRA_THEME_DIR . '/inc/class-vira-loader.php';

$vira_boot = array(
	'/inc/includes/option_to_functions.php',
	'/inc/includes/prk_actions.php',
	'/inc/includes/mob_cheker.php',
	'/inc/includes/mobile-functions.php',
	'/core.php',
	'/inc/options_includes.php',
	'/inc/widgets.php',
	'/inc/prk_enqueue_script.php',
	'/inc/woocomerce_functions/woocomerce_includes.php',
	'/inc/admin/post-type.php',
);

foreach ( $vira_boot as $rel ) {
	$path = VIRA_THEME_DIR . $rel;
	if ( is_readable( $path ) ) {
		require_once $path;
	}
}

require_once VIRA_THEME_DIR . '/inc/class-vira-init.php';
require_once VIRA_THEME_DIR . '/inc/digikala/digikala-layer.php';

function vira_theme_setup() {
	load_theme_textdomain( 'vira', VIRA_THEME_DIR . '/languages' );
	load_theme_textdomain( 'parskala', VIRA_THEME_DIR . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	register_nav_menus(
		array(
			'vira_header_menu' => 'منوی اصلی هدر ویرا',
			'vira_mobile_nav'  => 'منوی پایینی موبایل ویرا',
			'vira_footer_menu' => 'منوی فوتر ویرا',
			'header-menu'      => 'منوی هدر پارس‌کالا',
			'cat-menu'         => 'منوی دسته‌بندی',
		)
	);
}
add_action( 'after_setup_theme', 'vira_theme_setup', 5 );
