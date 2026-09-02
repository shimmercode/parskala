<?php


if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

$url = get_template_directory_uri().'/inc/PRKSMSApp/includes/templates/assets/';
wp_enqueue_style('prkSMSCSS', $url . 'css/prkSMS.css', true, 103);
wp_enqueue_script('prkSMSJS', $url . 'js/prkSMS.js', true, 103);
require_once dirname(__FILE__) . "/../PRKSMSAppClass.php";

$credit = 0;
if (!empty(PRKSMSAppClass::prk_opt('gateway_sms_panel_api_key'))) {
    $creditObject = PRKSMSAppClass::getCredit();

    if ($creditObject->status == 1) {
        $credit = $creditObject->data;
    }
  

}
if ((isset($_POST["deactivate"])) && ($_POST["deactivate"])) {
    deactivate_plugins("WoocommercePluginPRKSMS-V3.1/WoocommerceIR_SMS.php");
}
?>
<div class="prk-sms-header-div">
    <h1>
        <img width="100px" src="<?= parskala_IMG.'prk-sms-logo.png' ?>">
        پیامک پارس کالا
    </h1>
</div>
<div class="prk-sms-main-div">
    <table class="form-table">
        <tbody>
        <tr>
            <td>
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="dashicons dashicons-money-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">اعتبار پنل (پیامک)</span>
                        <span class="info-box-number"><?php echo $credit ?></span>
                    </div>
                </div>
            </td>
    
      
         
        </tr>
        </tbody>
    </table>

    <?php if (is_plugin_active("WoocommercePluginPRKSMS-V3.1/WoocommerceIR_SMS.php")) { ?>
        <div class="error">
            <p>نصب همزمان این افزونه با افزونه ارسال پیامک ووکامرس دیگر، باعث بروز مشکلاتی در وبسایت شما خواهد شد.
                لطفا نسبت به غیر فعال کردن ماژول مورد نظر اقدام فرمایید.</p>
            <form method="post" action="">
                <input type="hidden" name="deactivate" value="1">
                <button type="submit" class="button button-error">غیر فعال کردن</button>
            </form>
        </div>
    <?php } elseif ((isset($_POST["deactivate"])) && ($_POST["deactivate"]) && (!is_plugin_active("WoocommercePluginPRKSMS-V3.1/WoocommerceIR_SMS.php"))) { ?>
        <div class="updated">
            <p>افزونه ارسال پیامک ووکامرس با موفقیت غیر فعال شد.</p>
        </div>
    <?php } ?>
    <hr>
    <table class="form-table">
        <tbody>
        <tr>
            <td class="prk-sms-main-footer-text">
                <p>پارس کالا</p>
            </td>
        </tr>
        <tr>
            <td class="prk-sms-main-footer-text">
                <p>masirwp.com</p>
            </td>
        </tr>
        </tbody>
    </table>
</div>
