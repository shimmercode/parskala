<?php
/**
 * Vira Theme Header Template
 *
 * Displays all of the <head> section and the e-commerce header.
 *
 * @package Vira
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Direct access not allowed.
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <?php wp_head(); ?>
</head>

<body <?php body_class( 'vira-rtl-store' ); ?>>
<?php wp_body_open(); ?>

<div id="vira-page-wrapper" class="vira-page-wrapper">
    <header id="vira-header" class="vira-main-header">
        <!-- Top Notification / Announcement bar -->
        <div class="vira-header-topbar">
            <div class="vira-container topbar-inner">
                <div class="topbar-right">
                    <span class="support-phone">
                        <i class="xts-i-phone"></i> پشتیبانی ۲۴ ساعته: <strong><?php echo esc_html( vira_to_persian_num( '021-91001234' ) ); ?></strong>
                    </span>
                </div>
                <div class="topbar-left">
                    <?php if ( function_exists( 'vira_get_user_location' ) && vira_is_module_enabled( 'vira-location-selector' ) ) :
                        $location = vira_get_user_location();
                        ?>
                        <div class="vira-header-location-pill js-open-location-modal">
                            <i class="xts-i-marker"></i>
                            <span class="location-text">ارسال به: <strong><?php echo esc_html( $location['province'] . '، ' . $location['city'] ); ?></strong></span>
                            <i class="xts-i-arrow-down-xs"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Main E-Commerce Header -->
        <div class="vira-header-main">
            <div class="vira-container header-main-inner">
                <!-- Logo -->
                <div class="vira-logo-wrapper">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="vira-logo-link">
                        <span class="vira-logo-text">ویـــــرا</span>
                        <span class="vira-logo-sub">فروشگاه مدرن آنلاین</span>
                    </a>
                </div>

                <!-- [VIRA-01] Smart Search Bar -->
                <div class="vira-search-wrapper">
                    <form role="search" method="get" class="vira-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="search" class="vira-search-input" placeholder="جستجو در بین هزاران کالا، برند و دسته‌بندی..." value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
                        <input type="hidden" name="post_type" value="product" />
                        <button type="submit" class="vira-search-submit"><i class="xts-i-search"></i></button>
                    </form>
                    <div class="vira-ajax-search-results"></div>
                </div>

                <!-- User Account, Wishlist & Cart Icons -->
                <div class="vira-header-actions">
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : admin_url() ); ?>" class="header-action-icon" title="حساب کاربری">
                            <i class="xts-i-user"></i>
                            <span class="action-label">حساب من</span>
                        </a>
                    <?php else : ?>
                        <a href="#vira-otp-modal" class="header-action-icon js-open-otp-modal" title="ورود / عضویت">
                            <i class="xts-i-user"></i>
                            <span class="action-label">ورود | ثبت‌نام</span>
                        </a>
                    <?php endif; ?>

                    <?php if ( function_exists( 'wc_get_cart_url' ) && function_exists( 'WC' ) && WC() && WC()->cart ) : ?>
                        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-action-icon header-cart-link" title="سبد خرید">
                            <i class="xts-i-bag"></i>
                            <span class="cart-count-badge"><?php echo esc_html( vira_to_persian_num( WC()->cart->get_cart_contents_count() ) ); ?></span>
                            <span class="action-label">سبد خرید</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Primary Navigation Bar -->
        <nav class="vira-main-navbar" role="navigation">
            <div class="vira-container navbar-inner">
                <?php
                if ( has_nav_menu( 'vira_header_menu' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'vira_header_menu',
                        'container'      => false,
                        'menu_class'     => 'vira-nav-menu',
                        'depth'          => 3,
                    ) );
                } else {
                    ?>
                    <ul class="vira-nav-menu">
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">خانه</a></li>
                        <li><a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' ) ); ?>">فروشگاه</a></li>
                        <li><a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url() ); ?>">حساب کاربری</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/?s=' ) ); ?>">جستجو</a></li>
                    </ul>
                    <?php
                }
                ?>
            </div>
        </nav>
    </header>
