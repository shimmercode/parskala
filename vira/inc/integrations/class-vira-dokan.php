<?php
/**
 * Vira Theme Dokan & Multi-Vendor Trust Shield Integration ([VIRA-09])
 *
 * @package Vira
 * @since   1.0.0
 */

namespace Vira\Integrations;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Dokan_Integration {
    private static $instance = null;

    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private __construct() {
        if ( ! class_exists( 'WeDevs_Dokan' ) && ! function_exists( 'dokan' ) ) {
            return;
        }

        // Add Buy-Box & Vendor Shield on single product page
        add_action( 'woocommerce_single_product_summary', array( $this, 'render_dokan_buybox_shield' ), 25 );
    }

    public function render_dokan_buybox_shield() {
        if ( ! vira_is_module_enabled( '09-vendor-shield' ) ) {
            return;
        }
        global $product;
        if ( ! $product ) {
            return;
        }

        $vendor_id = get_post_field( 'post_author', $product->get_id() );
        $author    = get_userdata( $vendor_id );
        $store_url = function_exists( 'dokan_get_store_url' ) ? dokan_get_store_url( $vendor_id ) : '#';
        $rating    = '۴.۸ از ۵';
        ?>
        <div class="vira-dokan-buybox-shield">
            <div class="shield-header">
                <span class="shield-title"><i class="xts-i-store"></i> فروشنده منتخب:</span>
                <a href="<?php echo esc_url( $store_url ); ?>" class="vendor-name"><?php echo esc_html( $author ? $author->display_name : 'فروشگاه رسمی ویرا' ); ?></a>
            </div>
            <div class="shield-meta-row">
                <span class="vendor-rating"><i class="xts-i-star"></i> عملکرد فروشنده: <strong><?php echo esc_html( $rating ); ?></strong> (عالی)</span>
                <span class="vendor-guarantee"><i class="xts-i-check"></i> گارانتی ۱۸ ماهه شرکتی معتبر</span>
            </div>
            <div class="shield-footer">
                <a href="#vira-vendor-compare-modal" class="vendor-compare-link js-open-vendor-compare">
                    مشاهده ۲ فروشنده دیگر این کالا
                </a>
            </div>
        </div>
        <?php
    }
}

Dokan_Integration::get_instance();
```

