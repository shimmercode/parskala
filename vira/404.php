<?php
/**
 * Vira Theme 404 Error Template (RTL Persian)
 *
 * @package Vira
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>

<main id="main" class="vira-main-content" role="main">
    <div class="vira-container">
        <div class="vira-404-error-page" style="text-align: center; padding: 60px 20px;">
            <div class="error-number" style="font-size: 80px; font-weight: bold; color: #ef394e; line-height: 1;">۴۰۴</div>
            <h1 class="error-title" style="font-size: 24px; color: #1e293b; margin: 16px 0;">صفحه مورد نظر شما پیدا نشد!</h1>
            <p class="error-desc" style="color: #64748b; max-width: 500px; margin: 0 auto 24px;">
                متأسفانه صفحه‌ای که به دنبال آن هستید حذف شده یا آدرس آن تغییر کرده است. می‌توانید از طریق نوار جستجو یا دکمه زیر به خانه بازگردید.
            </p>
            <div class="error-search-box" style="max-width: 400px; margin: 0 auto 24px;">
                <?php get_search_form(); ?>
            </div>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button button-primary" style="background: #ef394e; color: #fff; padding: 12px 28px; border-radius: 8px; font-weight: bold; display: inline-block;">
                بازگشت به صفحه اصلی
            </a>
        </div>
    </div>
</main>

<?php
get_footer();
