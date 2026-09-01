<?php

if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
require_once dirname(__FILE__) . "/../PRKSMSAppClass.php";

global $wpdb, $table_prefix;
$url = get_template_directory_uri().'/inc/PRKSMSApp/includes/templates/assets/';
$nonce = wp_create_nonce("prk_sms_submit_settings_nonce");
wp_enqueue_style('prkSMSCSS', $url . 'css/prkSMS.css', true, 103);
wp_enqueue_script('prkSMSJS', $url . 'js/prkSMS.js', true, 103);
wp_localize_script( 'prkSMSJS', 'prk_sms_handler', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),'ajaxnonce'=>$nonce));        

?>
<div class="cotiner-PRKSMSApp">


    <div class="prk-sms-header-div">
        <h1>
        <img width="100px" src="<?= parskala_IMG.'prk-sms-logo-send-test.png' ?>">
        </h1>
    </div>
    
    <?php
    if (isset($_POST["prk_sms_test_button"]) && ($_POST["prk_sms_test_button"])) {
    
            $sms = PRKSMSAppClass::sendBulkSMS($_POST["prk_sms_text"], [$_POST["prk_sms_mobile"]]);
            if ($sms->status == 1) { ?>
                <div class="updated">
                    <p>ارسال پیامک با موفقیت انجام شد.</p>
                </div>
            <?php } else { ?>
                <div class="error">
                    <p><?= $sms->message ?></p>
                </div>
            <?php }
        
    }
    ?>
    <div class="row prk-sms-main-div prk-sms-setting-main-div" style="width: 98%">
        <div class="col-md-12" id="prkSMSTabContent">
            <form action="" method="post">
                <table class="form-table prk-sms-form-table">
                    <tbody>
                    <tr>
                        <td class="form-table-input">
                            <p class="prk-sms-label">شماره موبایل:</p>
                        </td>
                        <td class="form-table-input">
                            <input type="tel" name="prk_sms_mobile" class="prk-sms-form-control" placeholder="0912*******"
                                required value="<?php if (isset($_POST["prk_sms_mobile"])) {
                                echo trim($_POST["prk_sms_mobile"]);
                            } ?>">
                        </td>
                    </tr>
                    <tr>
                        <td class="form-table-input">
                            <p class="prk-sms-label">متن پیامک:</p>
                        </td>
                        <td class="form-table-input">
                            <textarea name="prk_sms_text" cols="5" class="prk-sms-form-control" placeholder="باسلام**********"
                                    required><?php if (isset($_POST["prk_sms_text"])) {
                                    echo trim($_POST["prk_sms_text"]);
                                } ?></textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
        
                <button type="submit" name="prk_sms_test_button" value="1" class="prk-sms-test-button button-primary">تست
                    ارسال پیامک
                </button>
            </form>
        </div>
    </div>
</div>