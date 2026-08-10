<?php

// includes codestar options
$prk_national_guard_file = parskala_TEMPLATEPATH . '/inc/modules/national-guard/national-guard.php';
if ( file_exists( $prk_national_guard_file ) ) {
    require_once $prk_national_guard_file;
}
include(parskala_TEMPLATEPATH.'/inc/prk-size-guide/prkSizeGuidePlugin.php');
require_once parskala_TEMPLATEPATH .'/inc/settings-opt.php';
include(parskala_TEMPLATEPATH.'/inc/includes/menu-options.php');
include(parskala_TEMPLATEPATH.'/inc/includes/categorys-options.php');
include(parskala_TEMPLATEPATH.'/inc/includes/metabox-option.php');
include(parskala_TEMPLATEPATH.'/my-functions.php');
