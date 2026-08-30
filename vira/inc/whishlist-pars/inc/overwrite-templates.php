<?php

add_filter('woocommerce_locate_core_template', 'sit_locate_template', 10, 3);
add_filter('woocommerce_locate_template', 'sit_locate_template', 10, 3);


function sit_locate_template($core_file, $template, $template_base)	{
    $_core_file = sit_wishlist_locate_template($template, $template_base);
    if (empty($_core_file)) {
        return $core_file;
    }

    return $_core_file;
}

function sit_wishlist_locate_template( $template_name, $template_path = '', $default_path = '' ) {
    $prefix = '';

    if ( substr( basename( $template_name ), 0, strlen( $prefix ) ) !== $prefix ) {
        return;
    }

    if ( ! $template_path ) {
        $template_path = WC()->template_path();
    }

    if ( ! $default_path ) {
        $default_path = SIT_PLUGIN_LOCATION . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
    }

    // Look within passed path within the theme - this is priority.
    $template = locate_template( array(
        trailingslashit( $template_path ) . $template_name,
        $template_name,
    ) );

    // Get default template.
    if ( ! $template && file_exists( $default_path . $template_name ) ) {
        $template = $default_path . $template_name;
    }

    // Return what we found.
    return apply_filters( 'sit_locate_template', $template, $template_name, $template_path );
}

function sit_wishlist_template( $template_name, $args = array(), $template_path = '' ) {
    if ( function_exists( 'wc_get_template' ) ) {
        wc_get_template( $template_name, $args, $template_path );
    } else {
        woocommerce_get_template( $template_name, $args, $template_path );
    }
}
