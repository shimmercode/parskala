<?php

if (!function_exists('PRKSMSApp_activate')) {
    /**
     * @return void
     */
    function PRKSMSApp_activate()
    {
      
        global $wpdb;
        $wpdb->query("CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}prk_sms_app_newsletter` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `mobile` BIGINT NOT NULL,
                `active` enum('0','1') DEFAULT '1',
                PRIMARY KEY(`id`)
            ) {$wpdb->get_charset_collate()};
        ");

        // $wpdb->query("ALTER TABLE `{$wpdb->prefix}prk_sms_app_newsletter`
        //     ADD UNIQUE KEY `mobile_number` (`mobile`);"
        // );

	    $wpdb->query("CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}prk_sms_app_log` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `title` varchar(100) NOT NULL,
                `message` varchar(100) NOT NULL,
                `status` INT(11) NOT NULL,
                `created_at` DATETIME NOT NULL,
                PRIMARY KEY(`id`)
            ) {$wpdb->get_charset_collate()};
        ");
    }
}

if (!function_exists('PRKSMSApp_deactivation')) {
    /**
     * @return void
     */
    function PRKSMSApp_deactivation()
    {
        global $wpdb;
        $wpdb->query("DROP TABLE `{$wpdb->prefix}prk_sms_app_newsletter`");
        $wpdb->query("DROP TABLE `{$wpdb->prefix}prk_sms_app_log`");
    }
}

/**
 * @return void
 */
function PRKSMSAppAdmin()
{
    add_submenu_page('prk-theme', 'تنظیمات پیامک', 'تنظیمات پیامک', "administrator", 'PRKSMSApp-setting', 'PRKSMSAppAdminSetting');
    add_submenu_page('prk-theme', 'ارسال پیامک', 'ارسال پیامک', "administrator", 'PRKSMSApp-test', 'PRKSMSAppAdminTest');
}

require_once(dirname(__FILE__) . '/includes/functions.php');
require_once dirname(__FILE__) . '/includes/action.php';
require_once dirname(__FILE__) . '/includes/woocommerce-order-tracking.php';
require_once dirname(__FILE__) . '/includes/notify-product-activity.php';
require_once dirname(__FILE__) . '/includes/prk-newsletter.php';


add_action('after_setup_theme','PRKSMSApp_activate');
add_action('switch_theme', 'PRKSMSApp_deactivation');

function update_pattern_login_code_new_version() {
    $prk_options = get_option('prk_option', []);

    if (!is_array($prk_options)) {
        $prk_options = [];
    }

    $old_login_meta   = trim((string) ($prk_options['gateway_sms_pattern_code'] ?? ''));
    $old_instock_meta = trim((string) ($prk_options['gateway_sms_pattern_code_instock_product'] ?? ''));
    $old_amazing_meta = trim((string) ($prk_options['gateway_sms_pattern_code_amazing_product'] ?? ''));

    if ($old_login_meta !== '') {
        $current_template = trim((string) get_option('prk_sms_otp_user_template', ''));

        if ($current_template === '') {
            update_option('prk_sms_otp_user_status', '1');
            update_option('prk_sms_otp_user_template', $old_login_meta);
            update_option('prk_sms_otp_user_text', '#code#');
        }
    }

    if ($old_instock_meta !== '') {
        $current_template = trim((string) get_option('prk_sms_woocommerce_inventory_user_template', ''));

        if ($current_template === '') {
            update_option('prk_sms_woocommerce_inventory_user_status', '1');
            update_option('prk_sms_woocommerce_inventory_user_template', $old_instock_meta);
            update_option('prk_sms_woocommerce_inventory_user_text', '#productname#');
        }
    }

    if ($old_amazing_meta !== '') {
        $current_template = trim((string) get_option('prk_sms_woocommerce_promotion_user_template', ''));

        if ($current_template === '') {
            update_option('prk_sms_woocommerce_promotion_user_status', '1');
            update_option('prk_sms_woocommerce_promotion_user_template', $old_amazing_meta);
            update_option('prk_sms_woocommerce_promotion_user_text', '#productname#');
        }
    }
}

