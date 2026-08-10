<?php
/**
 * Vira Theme Core Options & Framework Includes (Guarded Autoloader)
 *
 * @package Vira
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Load Codestar Framework FIRST so Class 'CSF' is always available
$vira_csf_file = parskala_TEMPLATEPATH . '/inc/codestar-framework/codestar-framework.php';
if ( file_exists( $vira_csf_file ) ) {
    require_once $vira_csf_file;
}

// 2. Load Size Guide Plugin safely
$vira_size_guide_file = parskala_TEMPLATEPATH . '/inc/prk-size-guide/prkSizeGuidePlugin.php';
if ( file_exists( $vira_size_guide_file ) ) {
    include_once $vira_size_guide_file;
} elseif ( file_exists( parskala_TEMPLATEPATH . '/inc/modules/vira-size-guide/prkSizeGuidePlugin.php' ) ) {
    include_once parskala_TEMPLATEPATH . '/inc/modules/vira-size-guide/prkSizeGuidePlugin.php';
}

// 3. Load Theme Settings Options (CSF Options) safely
$vira_settings_file = parskala_TEMPLATEPATH . '/inc/settings-opt.php';
if ( file_exists( $vira_settings_file ) && class_exists( 'CSF' ) ) {
    require_once $vira_settings_file;
}

// 4. Load Core Option Menus & Metaboxes safely
$vira_menu_opts = parskala_TEMPLATEPATH . '/inc/includes/menu-options.php';
if ( file_exists( $vira_menu_opts ) ) {
    include_once $vira_menu_opts;
}

$vira_cat_opts = parskala_TEMPLATEPATH . '/inc/includes/categorys-options.php';
if ( file_exists( $vira_cat_opts ) ) {
    include_once $vira_cat_opts;
}

$vira_meta_opts = parskala_TEMPLATEPATH . '/inc/includes/metabox-option.php';
if ( file_exists( $vira_meta_opts ) ) {
    include_once $vira_meta_opts;
}

$vira_my_funcs = parskala_TEMPLATEPATH . '/my-functions.php';
if ( file_exists( $vira_my_funcs ) ) {
    include_once $vira_my_funcs;
} elseif ( file_exists( parskala_TEMPLATEPATH . '/inc/vira-my-functions.php' ) ) {
    include_once parskala_TEMPLATEPATH . '/inc/vira-my-functions.php';
}
