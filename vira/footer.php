<?php
/**
 * Vira Theme Footer Template
 *
 * Displays footer links, copyright, modals, mobile bottom nav, and closing body tags.
 *
 * @package Vira
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Direct access not allowed.
}
?>
    <footer id="vira-footer" class="vira-main-footer">
        <div class="vira-footer-top">
            <div class="vira-container footer-grid">
                <div class="footer-col about-col">
                    <h3 class="footer-widget-title">درباره فروشگاه آنلاین ویرا</h3>
                    <p>پلتفرم فروشگاهی نسل جدید ویرا، ارائه‌دهنده سریع‌ترین تجربه خرید آنلاین با تنوع کالایی بی‌نظیر، ضمانت اصالت کالا، ۷ روز گارانتی بازگشت وجه و ارسال سریع به سراسر ایران.</p>
                </div>
                <div class="footer-col links-col">
                    <h3 class="footer-widget-title">راهنمای خریداران</h3>
                    <ul>
                        <li><a href="#">نحوه ثبت سفارش</a></li>
                        <li><a href="#">رویه ارسال کالا</a></li>
                        <li><a href="#">شیوه بازگرداندن کالا</a></li>
                        <li><a href="#">پرسش‌های متداول</a></li>
                    </ul>
                </div>
                <div class="footer-col links-col">
                    <h3 class="footer-widget-title">خدمات مشتریان</h3>
                    <ul>
                        <li><a href="#">پشتیبانی ۲۴ ساعته</a></li>
                        <li><a href="#">گزارش تخلف یا باگ</a></li>
                        <li><a href="#">فرصت‌های شغلی</a></li>
                        <li><a href="#">تماس با ما</a></li>
                    </ul>
                </div>
                <div class="footer-col trust-col">
                    <h3 class="footer-widget-title">نمادهای اعتماد الکترونیکی</h3>
                    <div class="trust-symbols">
                        <div class="trust-badge">نماد اعتماد الکترونیکی (e-Namad)</div>
                        <div class="trust-badge">ستاد ساماندهی وزارت ارشاد</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="vira-footer-bottom">
            <div class="vira-container bottom-inner">
                <p class="copyright-text">
                    کلیه حقوق مادی و معنوی این وب‌سایت متعلق به <strong>فروشگاه آنلاین ویرا (Vira)</strong> می‌باشد. &copy; <?php echo esc_html( vira_to_persian_num( date( 'Y' ) ) ); ?>
                </p>
            </div>
        </div>
    </footer>
</div><!-- #vira-page-wrapper -->

<!-- ==========================================================================
     VIRA MODAL OVERLAYS CONTAINER
     ========================================================================== -->

<?php if ( function_exists( 'vira_is_module_enabled' ) && vira_is_module_enabled( '20-otp-sms' ) ) : ?>
<div id="vira-otp-modal" class="vira-modal-overlay">
    <div class="vira-modal-box">
        <div class="vira-modal-header">
            <h3>ورود / عضویت سریع با شماره موبایل</h3>
            <button type="button" class="vira-modal-close">&times;</button>
        </div>
        <div class="vira-modal-body">
            <form id="vira-otp-form" class="vira-otp-form">
                <p>لطفاً شماره موبایل خود را وارد نمایید. کد تایید ورود برای شما پیامک خواهد شد.</p>
                <input type="text" name="mobile" placeholder="مثال: 09123456789" required autocomplete="tel" />
                <button type="submit" class="button">ارسال کد تایید پیامکی</button>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if ( function_exists( 'vira_is_module_enabled' ) && vira_is_module_enabled( 'vira-location-selector' ) ) : ?>
<div id="vira-location-modal" class="vira-modal-overlay">
    <div class="vira-modal-box">
        <div class="vira-modal-header">
            <h3>انتخاب استان و شهر تحویل کالا</h3>
            <button type="button" class="vira-modal-close">&times;</button>
        </div>
        <div class="vira-modal-body">
            <form id="vira-location-form" class="vira-location-form">
                <p>با انتخاب شهر خود، زمان و هزینه ارسال دقیق کالاها محاسبه می‌شود.</p>
                <div class="form-row" style="margin-bottom: 12px;">
                    <label>استان:</label>
                    <select id="vira-select-province" name="province" style="width: 100%; padding: 10px; border-radius: 8px;">
                        <?php
                        $catalog = function_exists( 'vira_get_iran_provinces_cities' ) ? vira_get_iran_provinces_cities() : array();
                        foreach ( $catalog as $prov => $cities ) {
                            echo '<option value="' . esc_attr( $prov ) . '">' . esc_html( $prov ) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-row" style="margin-bottom: 16px;">
                    <label>شهر:</label>
                    <select id="vira-select-city" name="city" style="width: 100%; padding: 10px; border-radius: 8px;">
                        <option value="تهران">تهران</option>
                    </select>
                </div>
                <button type="submit" class="button" style="width: 100%; background: #ef394e; color: #fff; padding: 10px; border: none; border-radius: 8px;">ذخیره موقعیت مکانی</button>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if ( function_exists( 'vira_is_module_enabled' ) && vira_is_module_enabled( 'vira-price-chart' ) ) : ?>
<div id="vira-price-chart-modal" class="vira-modal-overlay">
    <div class="vira-modal-box" style="max-width: 650px;">
        <div class="vira-modal-header">
            <h3>نمودار تغییرات قیمت محصول</h3>
            <button type="button" class="vira-modal-close">&times;</button>
        </div>
        <div class="vira-modal-body">
            <div style="position: relative; height: 320px; width: 100%;">
                <canvas id="vira-chart-canvas"></canvas>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php if ( function_exists( 'vira_is_module_enabled' ) && vira_is_module_enabled( 'vira-trust-modals' ) ) : ?>
<div id="vira-trust-modal" class="vira-modal-overlay">
    <div class="vira-modal-box">
        <div class="vira-modal-header">
            <h3>گزارش و پیشنهاد کاربر</h3>
            <button type="button" class="vira-modal-close">&times;</button>
        </div>
        <div class="vira-modal-body">
            <form id="vira-trust-form" class="vira-trust-form">
                <input type="hidden" name="product_id" value="" />
                <input type="hidden" name="type" value="" />
                <p>نظرات و پیشنهادات شما برای بهبود کیفیت اطلاعات کالا بسیار ارزشمند است.</p>
                <textarea name="content" rows="4" placeholder="جزئیات گزارش یا پیشنهاد قیمت بهتر خود را بنویسید..." required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;"></textarea>
                <button type="submit" class="button" style="width: 100%; background: #ef394e; color: #fff; padding: 10px; border: none; border-radius: 8px; margin-top: 12px;">ثبت گزارش</button>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
