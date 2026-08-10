<?php
/**
 * Vira Theme Integration for Woodmart Base Architecture (XTS Framework)
 *
 * @package Vira
 * @since   1.0.0
 */

namespace Vira\Integrations;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Woodmart_Integration {
    private static $instance = null;

    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private __construct() {
        add_filter( 'woodmart_localized_string_array', array( $this, 'customize_woodmart_strings' ) );
        add_filter( 'woodmart_get_opt', array( $this, 'override_woodmart_options' ), 10, 2 );
        add_action( 'woodmart_after_header', array( $this, 'render_location_pill_in_header' ), 15 );
    }

    public function customize_woodmart_strings( $strings ) {
        $strings['add_to_cart']       = 'افزودن به سبد خرید';
        $strings['buy_now']           = 'خرید فوری';
        $strings['wishlist']          = 'علاقه‌مندی‌ها';
        $strings['compare']           = 'مقایسه';
        $strings['quick_view']        = 'مشاهده سریع';
        return $strings;
    }

    public function override_woodmart_options( $val, $slug ) {
        // Ensure RTL and Persian styling defaults
        if ( 'rtl' === $slug ) {
            return true;
        }
        return $val;
    }

    public function render_location_pill_in_header() {
        if ( ! vira_is_module_enabled( 'parskala-location' ) ) {
            return;
        }
        $location = vira_get_user_location();
        ?>
        <div class="vira-header-location-pill js-open-location-modal">
            <i class="xts-i-marker"></i>
            <span class="location-text">ارسال به: <strong><?php echo esc_html( $location['province'] . '، ' . $location['city'] ); ?></strong></span>
            <i class="xts-i-arrow-down-xs"></i>
        </div>
        <?php
    }
}

Woodmart_Integration::get_instance();
```

