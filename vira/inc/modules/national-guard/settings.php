<?php
/**
 * ParsKala National Net Guard settings tab.
 */

defined('ABSPATH') || exit;

if (!function_exists('prk_ng_render_scanner_field')) {
    function prk_ng_render_scanner_field(): void
    {
        if (function_exists('prk_ng_guard')) {
            prk_ng_guard()->render_scanner();
        }
    }
}

if (class_exists('CSF')) {
    CSF::createSection($prefix, [
        'title' => 'گارد نت ملی',
        'id'    => 'prk_national_guard',
        'icon'  => 'ri-shield-check-line',
        'fields' => [
            [
                'type'    => 'notice',
                'style'   => 'info',
                'content' => 'این بخش درخواست‌های خارجی وردپرس، ووکامرس، المنتور و افزونه‌ها را از مسیر WP HTTP API ثبت می‌کند و در صورت نیاز قبل از ایجاد کندی یا Timeout مسدودشان می‌کند.',
            ],
            [
                'id'         => 'prk_ng_enabled',
                'type'       => 'switcher',
                'title'      => 'فعال‌سازی گارد نت ملی',
                'subtitle'   => 'با فعال‌سازی این گزینه، سیستم مانیتورینگ درخواست‌های خارجی روشن می‌شود. خود سیستم پیش‌فرض خاموش است، اما بعد از فعال‌سازی حالت پیش‌فرض روی مسدودسازی همه درخواست‌های خارجی به‌جز لیست مستثنی قرار دارد.',
                'text_width' => 80,
                'default'    => false,
            ],
            [
                'id'      => 'prk_ng_block_mode',
                'type'    => 'select',
                'title'   => 'حالت برخورد با درخواست خارجی',
                'default' => 'block_all_external',
                'options' => [
                    'log_only'           => 'فقط ثبت گزارش؛ بدون مسدودسازی',
                    'block_list'         => 'مسدودسازی فقط دامنه‌های داخل لیست بلاک',
                    'block_all_external' => 'مسدودسازی همه درخواست‌های خارجی به‌جز لیست مستثنی',
                ],
                'dependency' => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'type'    => 'heading',
                'content' => 'محدوده اجرا',
                'dependency' => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'id'         => 'prk_ng_apply_admin',
                'type'       => 'switcher',
                'title'      => 'مانیتور درخواست‌های پیشخوان',
                'subtitle'   => 'برای پیدا کردن درخواست‌هایی مثل api.wordpress.org و my.elementor.com این گزینه باید فعال باشد.',
                'text_width' => 80,
                'default'    => true,
                'dependency' => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'id'         => 'prk_ng_apply_front',
                'type'       => 'switcher',
                'title'      => 'مانیتور درخواست‌های فرانت سایت',
                'text_width' => 80,
                'default'    => true,
                'dependency' => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'id'         => 'prk_ng_apply_ajax',
                'type'       => 'switcher',
                'title'      => 'مانیتور درخواست‌های Ajax و REST',
                'text_width' => 80,
                'default'    => true,
                'dependency' => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'id'         => 'prk_ng_apply_cron',
                'type'       => 'switcher',
                'title'      => 'مانیتور درخواست‌های Cron',
                'subtitle'   => 'برای جلوگیری از لاگ‌های اضافه، به‌صورت پیش‌فرض خاموش است.',
                'text_width' => 80,
                'default'    => false,
                'dependency' => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'id'         => 'prk_ng_payment_safe_mode',
                'type'       => 'switcher',
                'title'      => 'حالت امن پرداخت',
                'subtitle'   => 'درگاه‌های پرداخت و شاپرک حتی در حالت سخت‌گیرانه با احتیاط بیشتری بررسی می‌شوند.',
                'text_width' => 80,
                'default'    => true,
                'dependency' => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'id'         => 'prk_ng_wp_api_short_circuit',
                'type'       => 'switcher',
                'title'      => 'قطع کامل APIهای بروزرسانی WordPress.org',
                'subtitle'   => 'وقتی api.wordpress.org داخل لیست بلاک باشد، این گزینه درخواست‌های بروزرسانی افزونه/پوسته/هسته و plugins_api را از ریشه short-circuit می‌کند تا حتی وارد cURL و Query Monitor نشوند.',
                'text_width' => 80,
                'default'    => true,
                'dependency' => ['prk_ng_enabled|prk_ng_block_mode', '==|!=', 'true|log_only'],
            ],
            [
                'id'         => 'prk_ng_replace_gravatar',
                'type'       => 'switcher',
                'title'      => 'جایگزینی آواتارهای خارجی Gravatar',
                'subtitle'   => 'آواتارهای secure.gravatar.com و دامنه‌های مشابه به یک آواتار محلی تبدیل می‌شوند تا مرورگر منتظر Timeout خارجی نماند.',
                'text_width' => 80,
                'default'    => true,
                'dependency' => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'type'    => 'heading',
                'content' => 'لیست‌های پیش‌فرض بلاک و مستثنی',
                'dependency' => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'id'          => 'prk_ng_blocklist',
                'type'        => 'textarea',
                'title'       => 'لیست دامنه‌های مسدود',
                'subtitle'    => 'هر دامنه در یک خط. از wildcard مثل *.elementor.com هم پشتیبانی می‌شود.',
                'default'     => class_exists('Prk_National_Guard') ? Prk_National_Guard::default_blocklist() : '',
                'attributes'  => ['rows' => 16, 'dir' => 'ltr'],
                'dependency'  => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'id'          => 'prk_ng_allowlist',
                'type'        => 'textarea',
                'title'       => 'لیست دامنه‌های مستثنی',
                'subtitle'    => 'درگاه‌های پرداخت، سرویس‌های پیامکی و دامنه‌های حیاتی را اینجا نگه دارید.',
                'default'     => class_exists('Prk_National_Guard') ? Prk_National_Guard::default_allowlist() : '',
                'attributes'  => ['rows' => 18, 'dir' => 'ltr'],
                'dependency'  => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'type'    => 'heading',
                'content' => 'اسکنر خودکار',
                'dependency' => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'id'          => 'prk_ng_scan_targets',
                'type'        => 'textarea',
                'title'       => 'صفحات هدف برای اسکن سریع',
                'subtitle'    => 'هر مورد در یک خط. موارد آماده: home، shop، cart، checkout، myaccount. همچنین می‌توانید URL کامل وارد کنید.',
                'default'     => class_exists('Prk_National_Guard') ? Prk_National_Guard::default_scan_targets() : '',
                'attributes'  => ['rows' => 6, 'dir' => 'ltr'],
                'dependency'  => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'id'      => 'prk_ng_max_log_rows',
                'type'    => 'number',
                'title'   => 'تعداد گزارش‌های ذخیره‌شده',
                'default' => 250,
                'unit'    => 'ردیف',
                'attributes' => [
                    'min' => 50,
                    'max' => 1000,
                    'step' => 50,
                ],
                'dependency' => ['prk_ng_enabled', '==', 'true'],
            ],
            [
                'id'       => 'prk_ng_scanner_callback',
                'type'     => 'callback',
                'function' => 'prk_ng_render_scanner_field',
            ],
        ],
    ]);
}
