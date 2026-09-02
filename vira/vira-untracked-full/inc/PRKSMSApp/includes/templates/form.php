<?php

$url = get_template_directory_uri().'/inc/PRKSMSApp/includes/templates/assets/';
wp_enqueue_style('prkSMSCSS', $url . 'css/prkSMS.css', true, 103);
wp_enqueue_script('prkSMSJS', $url . 'js/prkSMS.js', true, 103);

global $product, $wpdb, $table_prefix;

if (isset($_POST["prk_sms_type"]) && $_POST["prk_sms_type"]) {
    if (empty($_POST["prk_sms_name"])) {
        $error = "لطفا نام خود را وارد کنید.";
    } elseif (!preg_match("/^09[0-9]{9}$/", $_POST["prk_sms_mobile"])) {
        $error = "شماره موبایل وارد شده نامعتبر است.";
    } elseif (!in_array($_POST["prk_sms_type"], ["inventory", "promotion"])) {
        $error = "مقادیر وارد شده نامعتبر است.";
    } else {
        $notification = $wpdb->get_var($wpdb->prepare("SELECT `id` FROM `{$table_prefix}prk_sms_app_notifications` WHERE `type` = '%s' AND `mobile` = '%d' AND `product_id` = '%d'", $_POST["prk_sms_type"], $_POST["prk_sms_mobile"], $product->get_id()));
        if (!is_null($notification)) {
            $error = "شماره موبایل شما تکراری است.";
        }
    }

    if (!isset($error)) {
        $table = $table_prefix . 'prk_sms_app_notifications';
        $data = [
            'product_id' => $product->get_id(),
            'type'       => $_POST["prk_sms_type"],
            'name'       => $_POST["prk_sms_name"],
            'mobile'     => $_POST["prk_sms_mobile"]
        ];
        $format = ['%d', '%s', '%s', '%d'];
        $wpdb->insert($table, $data, $format);

        if (!$wpdb->insert_id) {
            $error = "ذخیره سازی اطلاعات با مشکل مواجه گردید.";
        } else {
            $message = "اطلاعات شما با موفقیت ذخیره سازی شد.";
        }
    }
}

if ((!$product->is_in_stock()) && (get_option("prk_sms_woocommerce_inventory_user_status"))) { ?>
    <section class="prk-sms-client-form prk-sms-inventory-form">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h5>موجود شد خبرم کن!</h5>
            </div>
            <div class="panel-body">
                <?php if (isset($error) && $error) { ?>
                    <p style="color: red"><?php echo $error; ?></p>
                <?php } elseif (isset($message) && $message) { ?>
                    <p style="color: green"><?php echo $message; ?></p>
                <?php } ?>
                <form action="" method="post">
                    <input type="text" name="prk_sms_name" class="woocommerce-Input woocommerce-Input--text input-text form-control" value="<?php echo (isset($_POST["prk_sms_name"]) && $_POST["prk_sms_name"])? $_POST["prk_sms_name"]: '' ?>" placeholder="نام خود را وارد کنید">
                    <input type="tel" name="prk_sms_mobile" class="woocommerce-Input woocommerce-Input--text input-text form-control" value="<?php echo (isset($_POST["prk_sms_mobile"]) && $_POST["prk_sms_mobile"])? $_POST["prk_sms_mobile"]: '' ?>" placeholder="شماره موبابل خود را وارد کنید">
                    <input type="hidden" name="prk_sms_type" value="inventory">
                    <button type="submit" class="woocommerce-button button btn btn-primary">ثبت</button>
                </form>
            </div>
        </div>
    </section>
<?php } ?>
<?php if ((!$product->is_on_sale()) && (get_option("prk_sms_woocommerce_promotion_user_status"))) { ?>
    <section class="prk-sms-client-form prk-sms-promotion-form">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h5>تخفیف دار شد خبرم کن!</h5>
            </div>
            <div class="panel-body">
                <?php if (isset($error) && $error) { ?>
                    <p style="color: red"><?php echo $error; ?></p>
                <?php } elseif (isset($message) && $message) { ?>
                    <p style="color: green"><?php echo $message; ?></p>
                <?php } ?>
                <form action="" method="post">
                    <input type="text" name="prk_sms_name" class="woocommerce-Input woocommerce-Input--text input-text form-control" value="<?php echo (isset($_POST["prk_sms_name"]) && $_POST["prk_sms_name"])? $_POST["prk_sms_name"]: '' ?>" placeholder="نام خود را وارد کنید">
                    <input type="tel" name="prk_sms_mobile" class="woocommerce-Input woocommerce-Input--text input-text form-control" value="<?php echo (isset($_POST["prk_sms_mobile"]) && $_POST["prk_sms_mobile"])? $_POST["prk_sms_mobile"]: '' ?>" placeholder="شماره موبابل خود را وارد کنید">
                    <input type="hidden" name="prk_sms_type" value="promotion">
                    <button type="submit" class="woocommerce-button button btn btn-primary">ثبت</button>
                </form>
            </div>
        </div>
    </section>
<?php } ?>
