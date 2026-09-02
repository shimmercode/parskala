<?php
/**
 * Vira Theme Helpers & Iranian E-Commerce Utility Functions
 *
 * @package Vira
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Direct access not allowed.
}

if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if ( ! function_exists( 'prk_option' ) ) {
    /**
     * Core theme option getter with sensible out-of-the-box defaults for Vira E-Commerce theme.
     *
     * @param string $option  Option key.
     * @param mixed  $default Fallback default value.
     * @return mixed
     */
    function prk_option( $option = '', $default = null ) {
        $options = get_option( 'prk_option', array() );
        if ( isset( $options[ $option ] ) && '' !== $options[ $option ] ) {
            return $options[ $option ];
        }
        $defaults = array(
            'header_style_type'       => 'default',
            'header_type'             => 'default',
            'footer_type'             => 'default',
            'footer_style_type'       => 'default',
            'theme-style'             => 'digikala',
            'fonts'                   => 'IRANSans',
            'fonts_admin'             => 'iransans',
            'prk_topbar_true'         => true,
            'prk_topbar_stikey'       => true,
            'header_search_true'      => true,
            'supports_true'           => true,
            'header_account'          => true,
            'header_minicart'         => true,
            'call_true'               => true,
            'call_page'               => '#support',
            'prk_shop_ajax_add'       => true,
            'ajax_add'                => '1',
            'post_archive_name'       => true,
            'post_archive_bio'        => true,
            'post_archive_pcontent'   => true,
            'post_archive_author'     => true,
            'post_archive_date'       => true,
            'footer_logo'             => true,
            'free_shipping_effect'    => true,
            'prk_filter_location'     => true,
        );
        if ( isset( $defaults[ $option ] ) ) {
            return $defaults[ $option ];
        }
        return $default;
    }
}

if ( ! function_exists( 'vira_option' ) ) {
    function vira_option( $option = '', $default = null ) {
        return prk_option( $option, $default );
    }
}

if ( ! function_exists( 'vira_to_persian_num' ) ) {
    /**
     * Convert English and Arabic numbers to Persian digits.
     *
     * @param string|int|float $str
     * @return string
     */
    function vira_to_persian_num( $str ) {
        $en = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
        $ar = array( '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' );
        $fa = array( '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' );
        return str_replace( array_merge( $en, $ar ), array_merge( $fa, $fa ), (string) $str );
    }
}

if ( ! function_exists( 'vira_format_toman' ) ) {
    /**
     * Format price in Toman with comma separators and Persian digits.
     *
     * @param float|int $price
     * @param bool      $persian_digits Whether to convert digits to Persian.
     * @return string
     */
    function vira_format_toman( $price, $persian_digits = true ) {
        $price_clean = intval( $price );
        $formatted   = number_format( $price_clean );
        if ( $persian_digits ) {
            $formatted = vira_to_persian_num( $formatted );
        }
        return $formatted . ' <span class="vira-toman-badge">تومان</span>';
    }
}

if ( ! function_exists( 'vira_is_module_enabled' ) ) {
    /**
     * Check whether a specific Vira module is enabled in Vira Admin Control Center.
     *
     * @param string $module_id Module identifier slug.
     * @param bool   $default   Default status if not saved.
     * @return bool
     */
    function vira_is_module_enabled( $module_id, $default = true ) {
        $options = get_option( 'vira_admin_modules_settings', array() );
        if ( isset( $options[ $module_id ] ) ) {
            return ! empty( $options[ $module_id ] );
        }
        return $default;
    }
}

if ( ! function_exists( 'vira_get_user_location' ) ) {
    /**
     * Get user's selected Province and City from cookie or WooCommerce session.
     *
     * @return array array('province' => string, 'city' => string)
     */
    function vira_get_user_location() {
        $location = array(
            'province' => 'تهران',
            'city'     => 'تهران',
        );

        if ( isset( $_COOKIE['vira_user_location'] ) ) {
            $decoded = json_decode( sanitize_text_field( wp_unslash( $_COOKIE['vira_user_location'] ) ), true );
            if ( is_array( $decoded ) ) {
                if ( ! empty( $decoded['province'] ) ) {
                    $location['province'] = sanitize_text_field( $decoded['province'] );
                }
                if ( ! empty( $decoded['city'] ) ) {
                    $location['city'] = sanitize_text_field( $decoded['city'] );
                }
            }
        }

        return $location;
    }
}

if ( ! function_exists( 'vira_send_sms' ) ) {
    /**
     * Unified Persian SMS Sender wrapper supporting Kavenegar, Melipayamak, FarazSMS, and integrated SMS engines.
     *
     * @param string $mobile    Recipient phone number.
     * @param string $message   Text message or OTP code.
     * @param string $pattern   Optional SMS pattern ID.
     * @param array  $params    Pattern parameters.
     * @return bool|array
     */
    function vira_send_sms( $mobile, $message, $pattern = null, $params = array() ) {
        $gateway = get_option( 'vira_sms_gateway', 'kavenegar' );
        $api_key = get_option( 'vira_sms_api_key', '' );

        if ( empty( $api_key ) ) {
            return false;
        }
        $sms_file = get_template_directory() . '/inc/sms/class-vira-sms.php';
        if ( file_exists( $sms_file ) ) {
            require_once $sms_file;
            if ( class_exists( 'Vira_Sms' ) ) {
                return Vira_Sms::send( $mobile, $message );
            }
        }
        return false;
    }
}

if ( ! function_exists( 'vira_get_iran_provinces_cities' ) ) {
    /**
     * Return Iranian Provinces and Major Cities array for location selector & address book.
     *
     * @return array
     */
    function vira_get_iran_provinces_cities() {
        return array(
            'تهران' => array( 'تهران', 'اسلام‌شهر', 'شهریار', 'قدس', 'ملارد', 'ورامین', 'پاکدشت' ),
            'خراسان رضوی' => array( 'مشهد', 'نیشابور', 'سبزوار', 'تربت حیدریه', 'قوچان' ),
            'اصفهان' => array( 'اصفهان', 'کاشان', 'خمینی‌شهر', 'نجف‌آباد', 'شاهین‌شهر' ),
            'فارس' => array( 'شیراز', 'مرودشت', 'جهرم', 'فسا', 'کازرون' ),
            'خوزستان' => array( 'اهواز', 'دزفول', 'آبادان', 'خرمشهر', 'بندر ماهشهر' ),
            'آذربایجان شرقی' => array( 'تبریز', 'مراغه', 'مرند', 'میانه', 'اهر' ),
            'آذربایجان غربی' => array( 'ارومیه', 'خوی', 'میاندوآب', 'بوکان', 'مهاباد' ),
            'البرز' => array( 'کرج', 'هشتگرد', 'نظرآباد', 'محمدشهر' ),
            'گیلان' => array( 'رشت', 'بندر انزلی', 'لاهیجان', 'لنگرود', 'تالش' ),
            'مازندران' => array( 'ساری', 'بابل', 'آمل', 'قائم‌شهر', 'تنکابن' ),
        );
    }
}

/* ==========================================================================
   VIRA BRANDED WRAPPERS FOR CORE ENGINE HOOKS & TEMPLATE TAGS
   ========================================================================== */

if ( ! function_exists( 'vira_get_product_brand_name' ) ) {
    function vira_get_product_brand_name( $product_id ) {
        return '';
    }
}

if ( ! function_exists( 'vira_add_to_wishlist_button' ) ) {
    function vira_add_to_wishlist_button() {
        return;
    }
}

if ( ! function_exists( 'vira_add_to_compare_button' ) ) {
    function vira_add_to_compare_button() {
        return;
    }
}

if ( ! function_exists( 'vira_swatches_list' ) ) {
    function vira_swatches_list() {
        return;
    }
}

if ( ! function_exists( 'prk_grid_loop_columns_product' ) ) {
	function prk_grid_loop_columns_product() {
		return 'style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px;"';
	}
}
