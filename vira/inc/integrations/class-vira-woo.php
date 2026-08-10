<?php
/**
 * Vira Theme WooCommerce Integration & Hooks
 *
 * @package Vira
 * @since   1.0.0
 */

namespace Vira\Integrations;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Woo_Integration {
    private static $instance = null;

    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private __construct() {
        // Price formatting in Persian Toman
        add_filter( 'wc_price', array( $this, 'format_persian_wc_price' ), 100, 4 );

        // Add Instant Buy button next to Add to Cart on single product ([VIRA-08])
        add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'render_instant_buy_button' ), 15 );

        // Add Price Chart & Trust Modals buttons on single product
        add_action( 'woocommerce_single_product_summary', array( $this, 'render_price_chart_button' ), 12 );
        add_action( 'woocommerce_single_product_summary', array( $this, 'render_trust_modals_buttons' ), 35 );

        // Free Shipping Progress Bar in mini cart and cart page ([VIRA-05])
        add_action( 'woocommerce_widget_shopping_cart_before_buttons', array( $this, 'render_free_shipping_progress_bar' ), 10 );
        add_action( 'woocommerce_before_cart_table', array( $this, 'render_free_shipping_progress_bar' ), 10 );

        // Iranian Tax Invoice button in My Account -> Orders (ParsKala Invoice)
        add_action( 'woocommerce_my_account_my_orders_actions', array( $this, 'add_invoice_order_action' ), 10, 2 );

        // Sticky Bar on single product footer ([VIRA-07])
        add_action( 'wp_footer', array( $this, 'render_sticky_purchase_bar' ), 50 );
    }

    public function format_persian_wc_price( $return, $price, $args, $unformatted_price ) {
        if ( is_admin() && ! wp_doing_ajax() ) {
            return $return;
        }
        $formatted = vira_format_toman( $price, true );
        return '<span class="woocommerce-Price-amount amount">' . $formatted . '</span>';
    }

    public function render_instant_buy_button() {
        if ( ! vira_is_module_enabled( '08-instant-buy' ) ) {
            return;
        }
        global $product;
        if ( ! $product || ! $product->is_in_stock() ) {
            return;
        }
        ?>
        <button type="button" class="vira-instant-buy-btn button alt" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
            <i class="xts-i-bag"></i>
            <span>خرید فوری</span>
        </button>
        <?php
    }

    public function render_price_chart_button() {
        if ( ! vira_is_module_enabled( 'parskala-price-chart' ) ) {
            return;
        }
        global $product;
        if ( ! $product ) {
            return;
        }
        ?>
        <div class="vira-price-chart-btn-wrapper">
            <button type="button" class="vira-price-chart-btn js-open-price-chart" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
                <i class="xts-i-chart"></i>
                <span>نمودار تاریخچه قیمت</span>
            </button>
        </div>
        <?php
    }

    public function render_trust_modals_buttons() {
        if ( ! vira_is_module_enabled( 'parskala-trust' ) ) {
            return;
        }
        global $product;
        if ( ! $product ) {
            return;
        }
        ?>
        <div class="vira-trust-modals-row">
            <a href="#" class="vira-trust-link js-open-better-price" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
                <i class="xts-i-tag"></i>
                <span>پیشنهاد قیمت بهتر</span>
            </a>
            <a href="#" class="vira-trust-link js-open-problem-report" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
                <i class="xts-i-info"></i>
                <span>گزارش نادرستی مشخصات</span>
            </a>
        </div>
        <?php
    }

    public function render_free_shipping_progress_bar() {
        if ( ! vira_is_module_enabled( '05-free-shipping' ) || ! WC()->cart ) {
            return;
        }
        $threshold = 1500000; // 1,500,000 Tomans free shipping threshold
        $subtotal  = WC()->cart->get_subtotal();
        $percent   = min( 100, intval( ( $subtotal / $threshold ) * 100 ) );
        $remain    = max( 0, $threshold - $subtotal );
        ?>
        <div class="vira-free-shipping-progress">
            <?php if ( $remain > 0 ) : ?>
                <div class="progress-label">
                    <span>فقط <strong><?php echo vira_format_toman( $remain ); ?></strong> دیگر تا <strong>ارسال رایگان</strong>!</span>
                </div>
            <?php else : ?>
                <div class="progress-label success">
                    <span>🎉 تبریک! سفارش شما مشمول <strong>ارسال رایگان</strong> شد.</span>
                </div>
            <?php endif; ?>
            <div class="progress-bar-track">
                <div class="progress-bar-fill" style="width: <?php echo esc_attr( $percent ); ?>%;"></div>
            </div>
        </div>
        <?php
    }

    public function add_invoice_order_action( $actions, $order ) {
        if ( ! vira_is_module_enabled( 'parskala-invoice' ) ) {
            return $actions;
        }
        $actions['vira_invoice'] = array(
            'url'  => wp_nonce_url( admin_url( 'admin-ajax.php?action=vira_print_invoice&order_id=' . $order->get_id() ), 'vira_invoice' ),
            'name' => 'دانلود فاکتور رسمی',
        );
        return $actions;
    }

    public function render_sticky_purchase_bar() {
        if ( ! is_product() || ! vira_is_module_enabled( '07-sticky-cart' ) ) {
            return;
        }
        global $product;
        if ( ! $product || ! $product->is_in_stock() ) {
            return;
        }
        ?>
        <div class="vira-sticky-purchase-bar">
            <div class="sticky-product-meta">
                <?php echo $product->get_image( 'thumbnail', array( 'class' => 'sticky-thumb' ) ); ?>
                <div class="sticky-title-price">
                    <span class="sticky-title"><?php echo esc_html( $product->get_name() ); ?></span>
                    <span class="sticky-price"><?php echo wc_price( $product->get_price() ); ?></span>
                </div>
            </div>
            <div class="sticky-actions">
                <button type="button" class="vira-sticky-add-btn button alt" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
                    افزودن به سبد خرید
                </button>
            </div>
        </div>
        <?php
    }
}

Woo_Integration::get_instance();
```

