<?php
/**
 * Vira Theme Central Admin Dashboard & Control Center ([VIRA-20] & Rule #23)
 *
 * @package Vira
 * @since   1.0.0
 */

namespace Vira\Admin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Direct access not allowed.
}

class Admin_Dashboard {
    /**
     * Singleton instance.
     */
    private static $instance = null;

    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'admin_menu', array( $this, 'register_menu_pages' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function register_menu_pages() {
        add_menu_page(
            'قالب ویرا (Vira Framework)',
            'قالب ویرا (Vira)',
            'manage_options',
            'vira-admin-dashboard',
            array( $this, 'render_control_center' ),
            'dashicons-store',
            3
        );
    }

    public function register_settings() {
        register_setting( 'vira_admin_modules_group', 'vira_admin_modules_settings' );
        register_setting( 'vira_admin_modules_group', 'vira_sms_gateway' );
        register_setting( 'vira_admin_modules_group', 'vira_sms_api_key' );
        register_setting( 'vira_admin_modules_group', 'vira_sms_sender' );
        register_setting( 'vira_admin_modules_group', 'vira_free_shipping_threshold' );
        register_setting( 'vira_admin_modules_group', 'vira_seller_economic_code' );
        register_setting( 'vira_admin_modules_group', 'vira_installment_api_key' );
        register_setting( 'vira_admin_modules_group', 'vira_installment_provider' );
        register_setting( 'vira_admin_modules_group', 'vira_geocoding_enable' );
        register_setting( 'vira_admin_modules_group', 'vira_store_verified' );
        register_setting( 'vira_admin_modules_group', 'vira_store_trust_score' );
        register_setting( 'vira_admin_modules_group', 'vira_b2b_global_percent' );
    }

    public function get_modules_catalog() {
        return array(
            'exclusive' => array(
                'title' => '۲۰ ماژول پیشرفته و انحصاری ویرا (Vira Exclusive Next-Gen Modules)',
                'items' => array(
                    '01-smart-search'     => 'جستجوی هوشمند ایجکسی و پیشنهاددهنده زنده ([VIRA-01])',
                    '02-bottom-nav'       => 'ناوبری شناور پایینی موبایل و هدر چسبان ([VIRA-02])',
                    '03-ajax-filter'      => 'کشوی فیلترهای پیشرفته ایجکس بدون رفرش ([VIRA-03])',
                    '04-product-card'     => 'کارت محصول نسل جدید ایران با بج‌های اعتماد ([VIRA-04])',
                    '05-free-shipping'    => 'نوار هوشمند پیشرفت ارسال رایگان در سبد خرید ([VIRA-05])',
                    '06-installment-calc' => 'محاسبه‌گر لحظه‌ای اقساط (اسنپ‌پی، تارا، دیجی‌پی) ([VIRA-06])',
                    '07-sticky-cart'      => 'نوار خرید چسبان دسکتاپ و نوار پایینی موبایل ([VIRA-07])',
                    '08-instant-buy'      => 'خرید فوری تک‌کلیکی بدون عبور از سبد خرید ([VIRA-08])',
                    '09-vendor-shield'    => 'سپر اعتماد چندفروشندگی دکان و فروشنده منتخب ([VIRA-09])',
                    '10-bundle-discount'  => 'خرید پکیجی و محصولات مکمل با تخفیف ویژه ([VIRA-10])',
                    '11-stock-timer'      => 'تایمر شگفت‌انگیز و شمارنده موجودی زنده انبار ([VIRA-11])',
                    '12-media-reviews'    => 'گالری نظرات تصویری و ویدیویی خریداران ([VIRA-12])',
                    '13-diff-compare'     => 'جدول مقایسه هوشمند با هایلایت تفاوت‌ها ([VIRA-13])',
                    '14-ai-recommend'     => 'پیشنهاددهنده هوشمند بر اساس رفتار خریدار ([VIRA-14])',
                    '15-price-alert'      => 'آگاه‌سازی پیامکی کاهش قیمت و موجودی محصول ([VIRA-15])',
                    '16-iran-checkout'    => 'تسویه‌حساب ۳ مرحله‌ای بدون اصطکاک ایران ([VIRA-16])',
                    '17-map-address'      => 'دفترچه آدرس هوشمند با قابلیت انتخاب روی نقشه ([VIRA-17])',
                    '18-tiered-pricing'   => 'قیمت‌گذاری پلکانی عمده‌فروشی و B2B ([VIRA-18])',
                    '19-seo-schema'       => 'موتور تولید خودکار اسکیما و سئوی فروشگاهی ([VIRA-19])',
                    '20-otp-sms'          => 'سیستم ورود و ثبت‌نام پیامکی (OTP) ([VIRA-20])',
                ),
            ),
            'base_modules' => array(
                'title' => 'ماژول‌های پایه‌ای و ساختاری ویرا (Vira Base E-Commerce Modules)',
                'items' => array(
                    'vira-location-selector' => 'انتخاب‌گر استان و شهر با ذخیره‌سازی کوکی (Location Cookie)',
                    'vira-tax-invoice'       => 'صدور فاکتور رسمی و غیررسمی مالیاتی (Tax Invoice)',
                    'vira-price-chart'       => 'نمودار تاریخچه تغییرات قیمت محصول (Price History Chart)',
                    'vira-product-stories'   => 'استوری‌های فروشگاهی دیجی‌کالا/اینستاگرام (Product Stories)',
                    'vira-trust-modals'      => 'گزارش قیمت بهتر و نادرستی مشخصات (Better Price Report)',
                    'vira-guest-tracking'    => 'پیگیری سفارش مهمان با شماره موبایل (Guest Order Tracking)',
                    'vira-loyalty-rewards'   => 'تبدیل امتیاز به کد تخفیف در حساب کاربری (Loyalty Rewards)',
                    'vira-next-shopping'     => 'لیست خرید بعدی / انتقال از سبد خرید (Save for Later)',
                    'vira-size-guide'        => 'راهنمای سایز اختصاصی پوشاک و کفش (Size Guide Modal)',
                ),
            ),
        );
    }

    public function render_control_center() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $options  = get_option( 'vira_admin_modules_settings', array() );
        $catalog  = $this->get_modules_catalog();
        ?>
        <div class="wrap vira-admin-wrap" style="direction: rtl; text-align: right; font-family: Tahoma, Arial, sans-serif;">
            <div class="vira-admin-header" style="background: #ef394e; color: #fff; padding: 20px; border-radius: 12px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="color: #fff; margin: 0; font-size: 24px; font-weight: bold;">پلتفرم فروشگاهی ویرا (Vira E-Commerce Framework)</h1>
                    <p style="margin: 5px 0 0 0; opacity: 0.9;">مرکز فرماندهی ماژول‌های اختصاصی ویرا — طراحی انحصاری برای بازار ایران</p>
                </div>
                <div>
                    <span style="background: rgba(255,255,255,0.2); padding: 6px 14px; border-radius: 20px; font-size: 13px;">نسخه ۱.۰.۰ (Vira Core)</span>
                </div>
            </div>

            <form method="post" action="options.php">
                <?php
                settings_fields( 'vira_admin_modules_group' );
                do_settings_sections( 'vira_admin_modules_group' );
                ?>

                <div class="vira-admin-sections" style="display: grid; grid-template-columns: 1fr; gap: 24px;">
                    <?php foreach ( $catalog as $group_key => $group ) : ?>
                        <div class="vira-card" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.03);">
                            <h2 style="margin-top: 0; padding-bottom: 12px; border-bottom: 2px solid #ef394e; font-size: 18px; color: #1e293b;">
                                <?php echo esc_html( $group['title'] ); ?>
                            </h2>
                            <div class="vira-modules-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px; margin-top: 16px;">
                                <?php foreach ( $group['items'] as $slug => $label ) : 
                                    $is_checked = isset( $options[ $slug ] ) ? ! empty( $options[ $slug ] ) : true;
                                ?>
                                    <div class="vira-module-toggle-item" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px;">
                                        <label for="vira_mod_<?php echo esc_attr( $slug ); ?>" style="font-weight: 500; font-size: 13px; color: #334155; cursor: pointer;">
                                            <?php echo esc_html( $label ); ?>
                                        </label>
                                        <input type="checkbox" 
                                               id="vira_mod_<?php echo esc_attr( $slug ); ?>" 
                                               name="vira_admin_modules_settings[<?php echo esc_attr( $slug ); ?>]" 
                                               value="1" 
                                               <?php checked( $is_checked, true ); ?> 
                                               style="transform: scale(1.2); cursor: pointer;" />
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="vira-card" style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;margin-top:24px;">
                    <h2>تنظیمات یکپارچه‌سازی</h2>
                    <p><label>آستانه ارسال رایگان (تومان)<br>
                    <input type="number" name="vira_free_shipping_threshold" value="<?php echo esc_attr( get_option( 'vira_free_shipping_threshold', 1500000 ) ); ?>"></label></p>
                    <p><label>SMS API Key (Kavenegar)<br>
                    <input type="password" name="vira_sms_api_key" value="<?php echo esc_attr( get_option( 'vira_sms_api_key', '' ) ); ?>" autocomplete="off"></label></p>
                    <p><label>SMS Sender<br>
                    <input type="text" name="vira_sms_sender" value="<?php echo esc_attr( get_option( 'vira_sms_sender', '' ) ); ?>"></label></p>
                    <p><label>کد اقتصادی فروشنده (فقط اگر واقعی است)<br>
                    <input type="text" name="vira_seller_economic_code" value="<?php echo esc_attr( get_option( 'vira_seller_economic_code', '' ) ); ?>"></label></p>
                    <p><label>Installment API Key<br>
                    <input type="password" name="vira_installment_api_key" value="<?php echo esc_attr( get_option( 'vira_installment_api_key', '' ) ); ?>" autocomplete="off"></label></p>
                    <p><label>Installment provider
                    <select name="vira_installment_provider">
                        <option value="snappay" <?php selected( get_option( 'vira_installment_provider' ), 'snappay' ); ?>>SnappPay</option>
                        <option value="tara" <?php selected( get_option( 'vira_installment_provider' ), 'tara' ); ?>>Tara</option>
                        <option value="digipay" <?php selected( get_option( 'vira_installment_provider' ), 'digipay' ); ?>>DigiPay</option>
                    </select></label></p>
                    <p><label><input type="checkbox" name="vira_geocoding_enable" value="1" <?php checked( get_option( 'vira_geocoding_enable' ), '1' ); ?>> فعال‌سازی reverse geocoding (Nominatim)</label></p>
                    <p><label><input type="checkbox" name="vira_store_verified" value="1" <?php checked( get_option( 'vira_store_verified' ), '1' ); ?>> فروشگاه تأییدشده ویرا</label></p>
                    <p><label>امتیاز اعتماد فروشگاه <input type="number" name="vira_store_trust_score" value="<?php echo esc_attr( get_option( 'vira_store_trust_score', 0 ) ); ?>"></label></p>
                    <p><label>تخفیف سراسری B2B % از ۱۰ عدد <input type="number" name="vira_b2b_global_percent" value="<?php echo esc_attr( get_option( 'vira_b2b_global_percent', 0 ) ); ?>"></label></p>
                </div>
                <div style="margin-top: 24px;">
                    <?php submit_button( 'ذخیره تنظیمات ماژول‌های ویرا', 'primary large', 'submit', false, array( 'style' => 'background: #ef394e; border-color: #d62d41; padding: 10px 30px; font-size: 15px;' ) ); ?>
                </div>
            </form>
        </div>
        <?php
    }
}

Admin_Dashboard::get_instance();


