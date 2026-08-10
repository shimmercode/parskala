<?php
/**
 * Vira Theme Unified AJAX Controller & Endpoint Handler
 *
 * @package Vira
 * @since   1.0.0
 */

namespace Vira\Ajax;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Direct access not allowed.
}

class Ajax_Controller {
    private static $instance = null;

    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // [VIRA-20] OTP SMS Login/Register
        $this->add_ajax( 'vira_send_otp', 'handle_send_otp', true );
        $this->add_ajax( 'vira_verify_otp', 'handle_verify_otp', true );

        // Vira Location Selector (Cookie)
        $this->add_ajax( 'vira_get_cities', 'handle_get_cities', true );
        $this->add_ajax( 'vira_save_location', 'handle_save_location', true );

        // Vira Price History Chart
        $this->add_ajax( 'vira_get_price_chart', 'handle_get_price_chart', true );

        // Vira Trust Modals (Better Price / Problem Report)
        $this->add_ajax( 'vira_submit_trust_report', 'handle_submit_trust_report', true );

        // [VIRA-06] Installment Calculator
        $this->add_ajax( 'vira_calc_installments', 'handle_calc_installments', true );

        // [VIRA-08] Instant Buy Express
        $this->add_ajax( 'vira_instant_buy', 'handle_instant_buy', true );

        // Vira Guest Order Tracking
        $this->add_ajax( 'vira_guest_track_order', 'handle_guest_track_order', true );

        // Vira Loyalty Reward Points to Coupon
        $this->add_ajax( 'vira_convert_points_coupon', 'handle_convert_points_coupon', false );
    }

    private function add_ajax( $action, $method, $nopriv = false ) {
        add_action( 'wp_ajax_' . $action, array( $this, $method ) );
        if ( $nopriv ) {
            add_action( 'wp_ajax_nopriv_' . $action, array( $this, $method ) );
        }
    }

    private function verify_security() {
        if ( ! check_ajax_referer( 'vira_ajax_nonce', 'security', false ) ) {
            wp_send_json_error( array( 'message' => 'خطای امنیتی: توکن معتبر نیست. لطفاً صفحه را رفرش کنید.' ), 403 );
        }
    }

    /**
     * Handle OTP Send (Persian mobile validation)
     */
    public function handle_send_otp() {
        $this->verify_security();
        $mobile = isset( $_POST['mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['mobile'] ) ) : '';

        if ( ! preg_match( '/^09[0-9]{9}$/', $mobile ) ) {
            wp_send_json_error( array( 'message' => 'شماره موبایل وارد شده معتبر نیست. (مثال: 09123456789)' ) );
        }

        $code = wp_rand( 10000, 99999 );
        set_transient( 'vira_otp_' . md5( $mobile ), $code, 5 * MINUTE_IN_SECONDS );

        $sent = vira_send_sms( $mobile, 'کد ورود شما به ویرا: ' . $code );

        wp_send_json_success( array(
            'message' => 'کد تایید ۵ رقمی به شماره موبایل شما ارسال شد.',
            'mobile'  => $mobile,
        ) );
    }

    /**
     * Handle OTP Verification & Login
     */
    public function handle_verify_otp() {
        $this->verify_security();
        $mobile = isset( $_POST['mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['mobile'] ) ) : '';
        $code   = isset( $_POST['code'] ) ? sanitize_text_field( wp_unslash( $_POST['code'] ) ) : '';

        $saved = get_transient( 'vira_otp_' . md5( $mobile ) );
        if ( ! $saved || (string) $saved !== (string) $code ) {
            wp_send_json_error( array( 'message' => 'کد تایید اشتباه است یا منقضی شده است.' ) );
        }

        delete_transient( 'vira_otp_' . md5( $mobile ) );

        $user_query = get_users( array(
            'meta_key'   => 'vira_mobile',
            'meta_value' => $mobile,
            'number'     => 1,
        ) );

        $user_id = 0;
        if ( ! empty( $user_query ) ) {
            $user_id = $user_query[0]->ID;
        } else {
            $username = 'user_' . substr( $mobile, 3 );
            $user_id  = wp_create_user( $username, wp_generate_password(), $mobile . '@vira-store.ir' );
            if ( ! is_wp_error( $user_id ) ) {
                update_user_meta( $user_id, 'vira_mobile', $mobile );
            }
        }

        if ( $user_id && ! is_wp_error( $user_id ) ) {
            wp_clear_auth_cookie();
            wp_set_current_user( $user_id );
            wp_set_auth_cookie( $user_id, true );
            wp_send_json_success( array(
                'message' => 'ورود با موفقیت انجام شد.',
                'redirect'=> home_url( '/' ),
            ) );
        }

        wp_send_json_error( array( 'message' => 'خطا در ایجاد حساب کاربری.' ) );
    }

    /**
     * Get cities for selected province (Location Selector)
     */
    public function handle_get_cities() {
        $this->verify_security();
        $province = isset( $_POST['province'] ) ? sanitize_text_field( wp_unslash( $_POST['province'] ) ) : '';
        $catalog  = vira_get_iran_provinces_cities();

        $cities = isset( $catalog[ $province ] ) ? $catalog[ $province ] : array();
        wp_send_json_success( array(
            'province' => $province,
            'cities'   => $cities,
        ) );
    }

    /**
     * Save user location selection in storage cookie
     */
    public function handle_save_location() {
        $this->verify_security();
        $province = isset( $_POST['province'] ) ? sanitize_text_field( wp_unslash( $_POST['province'] ) ) : '';
        $city     = isset( $_POST['city'] ) ? sanitize_text_field( wp_unslash( $_POST['city'] ) ) : '';

        $data = json_encode( array(
            'province' => $province,
            'city'     => $city,
            'time'     => time(),
        ) );

        setcookie( 'vira_user_location', $data, time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
        wp_send_json_success( array(
            'message'  => "موقعیت مکانی روی $province - $city تنظیم شد.",
            'province' => $province,
            'city'     => $city,
        ) );
    }

    /**
     * Get Price Chart History for product (Chart.js)
     */
    public function handle_get_price_chart() {
        $this->verify_security();
        $product_id = isset( $_GET['product_id'] ) ? absint( $_GET['product_id'] ) : 0;
        if ( ! $product_id ) {
            wp_send_json_error( array( 'message' => 'محصول نامعتبر است.' ) );
        }

        $history = get_post_meta( $product_id, '_vira_price_history', true );
        if ( ! is_array( $history ) || empty( $history ) ) {
            $current_price = intval( get_post_meta( $product_id, '_price', true ) );
            if ( ! $current_price ) {
                $current_price = 1250000;
            }
            $history = array(
                array( 'date' => '۱۴۰۵/۰۲/۰۱', 'price' => $current_price * 1.05 ),
                array( 'date' => '۱۴۰۵/۰۳/۱۵', 'price' => $current_price * 1.02 ),
                array( 'date' => '۱۴۰۵/۰۴/۲۰', 'price' => $current_price * 0.98 ),
                array( 'date' => '۱۴۰۵/۰۵/۱۰', 'price' => $current_price ),
            );
        }

        wp_send_json_success( array(
            'product_id' => $product_id,
            'labels'     => wp_list_pluck( $history, 'date' ),
            'prices'     => wp_list_pluck( $history, 'price' ),
            'currency'   => 'تومان',
        ) );
    }

    /**
     * Handle Trust Report submission (Better Price or Specification Problem)
     */
    public function handle_submit_trust_report() {
        $this->verify_security();
        $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
        $type       = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : 'better_price';
        $content    = isset( $_POST['content'] ) ? sanitize_textarea_field( wp_unslash( $_POST['content'] ) ) : '';

        if ( ! $product_id || empty( $content ) ) {
            wp_send_json_error( array( 'message' => 'لطفاً تمامی فیلدهای ضروری را پر کنید.' ) );
        }

        add_post_meta( $product_id, '_vira_trust_report_' . time(), array(
            'type'    => $type,
            'content' => $content,
            'user_id' => get_current_user_id(),
            'date'    => current_time( 'mysql' ),
        ) );

        wp_send_json_success( array(
            'message' => 'گزارش شما با موفقیت ثبت شد و توسط تیم پشتیبانی بررسی می‌شود. با تشکر از همکاری شما.',
        ) );
    }

    /**
     * Installment Calculator JSON Data ([VIRA-06])
     */
    public function handle_calc_installments() {
        $price = isset( $_GET['price'] ) ? intval( $_GET['price'] ) : 0;
        if ( ! $price ) {
            $price = 1000000;
        }

        $snapp = intval( $price / 4 );
        $tara  = intval( ($price * 1.08) / 6 );
        $digi  = intval( ($price * 1.15) / 12 );

        wp_send_json_success( array(
            'snapp_4' => vira_format_toman( $snapp ),
            'tara_6'  => vira_format_toman( $tara ),
            'digi_12' => vira_format_toman( $digi ),
        ) );
    }

    /**
     * Instant Express Buy handler ([VIRA-08])
     */
    public function handle_instant_buy() {
        $this->verify_security();
        $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
        $qty        = isset( $_POST['qty'] ) ? absint( $_POST['qty'] ) : 1;

        if ( ! $product_id || ! class_exists( 'WooCommerce' ) ) {
            wp_send_json_error( array( 'message' => 'امکان خرید فوری این محصول وجود ندارد.' ) );
        }

        WC()->cart->empty_cart();
        WC()->cart->add_to_cart( $product_id, $qty );

        wp_send_json_success( array(
            'redirect' => wc_get_checkout_url(),
        ) );
    }

    /**
     * Guest Order Tracking via mobile and order id
     */
    public function handle_guest_track_order() {
        $this->verify_security();
        $order_id = isset( $_POST['order_id'] ) ? absint( $_POST['order_id'] ) : 0;
        $mobile   = isset( $_POST['mobile'] ) ? sanitize_text_field( wp_unslash( $_POST['mobile'] ) ) : '';

        if ( ! $order_id || empty( $mobile ) || ! class_exists( 'WooCommerce' ) ) {
            wp_send_json_error( array( 'message' => 'شماره سفارش یا شماره موبایل نامعتبر است.' ) );
        }

        $order = wc_get_order( $order_id );
        if ( ! $order || $order->get_billing_phone() !== $mobile ) {
            wp_send_json_error( array( 'message' => 'سفارشی با این مشخصات یافت نشد.' ) );
        }

        wp_send_json_success( array(
            'status'     => wc_get_order_status_name( $order->get_status() ),
            'total'      => vira_format_toman( $order->get_total() ),
            'date'       => vira_to_persian_num( wc_format_datetime( $order->get_date_created() ) ),
            'status_raw' => $order->get_status(),
        ) );
    }

    /**
     * Convert Loyalty Points to WooCommerce Coupon
     */
    public function handle_convert_points_coupon() {
        $this->verify_security();
        if ( ! is_user_logged_in() || ! class_exists( 'WooCommerce' ) ) {
            wp_send_json_error( array( 'message' => 'ابتدا وارد حساب کاربری خود شوید.' ) );
        }

        $user_id = get_current_user_id();
        $points  = intval( get_user_meta( $user_id, '_vira_loyalty_points', true ) );

        if ( $points < 100 ) {
            wp_send_json_error( array( 'message' => 'حداقل امتیاز لازم برای دریافت کد تخفیف ۱۰۰ امتیاز است.' ) );
        }

        $coupon_code = 'VIRA-' . strtoupper( wp_generate_password( 6, false ) );
        $amount      = $points * 1000;

        $coupon = new \WC_Coupon();
        $coupon->set_code( $coupon_code );
        $coupon->set_discount_type( 'fixed_cart' );
        $coupon->set_amount( $amount );
        $coupon->set_individual_use( true );
        $coupon->set_usage_limit( 1 );
        $coupon->save();

        update_user_meta( $user_id, '_vira_loyalty_points', 0 );

        wp_send_json_success( array(
            'message' => 'کد تخفیف با موفقیت ساخته شد: ' . $coupon_code,
            'coupon'  => $coupon_code,
            'amount'  => vira_format_toman( $amount ),
        ) );
    }
}

Ajax_Controller::get_instance();
```

