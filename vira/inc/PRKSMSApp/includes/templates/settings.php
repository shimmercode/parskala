<?php


if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

global $wpdb, $table_prefix;
$url = get_template_directory_uri().'/inc/PRKSMSApp/includes/templates/assets/';
$nonce = wp_create_nonce("prk_sms_submit_settings_nonce");

wp_enqueue_style('prkSMSCSS', $url . 'css/prkSMS.css', true, 103);
wp_enqueue_script('prkSMSJS', $url . 'js/prkSMS.js', true, 103);
wp_localize_script( 'prkSMSJS', 'prk_sms_handler', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),'ajaxnonce'=>$nonce));        

$chosen_gateway = prk_option('chose_panel_sms', 'melipayamak');



if (isset($_POST["prk_sms_setting_button"])) {
    foreach ($_POST as $key => $post) {
        if (((strpos($key, 'prk_sms_') === 0)) && (strlen(trim($post)))) {
            update_option($key, $post);
        } else {
            delete_option($key);
        }
    }
    echo "<div class='updated'><p>تغییرات با موفقیت در سیستم ثبت شد.</p></div>";
}


$contactForms = $wpdb->get_results("SELECT p.`ID` AS `id`, p.`post_title` AS `title`, pm.`meta_value` FROM `{$table_prefix}posts` AS p JOIN `{$table_prefix}postmeta` AS pm ON pm.`post_id` = p.`ID` AND pm.`meta_key` = '_form' WHERE p.`post_type` = 'wpcf7_contact_form'");


$woocommerceStatuses = [];
if (class_exists('woocommerce')) {
    $woocommerceStatuses = wc_get_order_statuses();
}
?>




<?php if (count($woocommerceStatuses) == 0) { ?>
    <div class="error">
        <p>متاسفانه افزونه WooCommerce در وبسایت شما فعال نیست و یا هیچ وضعیت سفارشی ایجاد نشده است.</p>
    </div>
<?php } ?>

<?php if (count($contactForms) == 0) { ?>
    <div class="error">
        <p>متاسفانه افزونه Contact7 در وبسایت شما فعال نیست و یا هیچ فرمی ایجاد نشده است.</p>
    </div>
<?php } ?>


<div class="cotiner-PRKSMSApp">

    <div class="PRKSMSApp-header">

    <div class="csf-header-inner">
        <div class="csf-header-left">
            <div class="prk-sidebar-logo">
            <img width="100px" src="<?= parskala_IMG.'prk-sms-logo.png' ?>">
            </div>
        
        </div>
        
        <div class="csf-header-right">

        </div>
        
    </div>  



</div>

<div class="row prk-sms-main-div prk-sms-setting-main-div ">
      


    <div class="col-md-12" id="prkSMSTabMenu">

        <div class="nav-tab-wrapper">
            <a href="#Woocommerce" onclick="prkSMSChangeTab('Woocommerce')" class="nav-tab nav-tab-active">
            <i class="ri-question-answer-line"></i>
            ووکامرس
        </a>
            <a href="#Contact" onclick="prkSMSChangeTab('Contact')" class="nav-tab ">
            <i class="ri-mail-send-line"></i>
            فرم ساز7</a>

        </div>
    </div>

    <div class="col-md-12" id="prkSMSTabContent">
        <form action="" method="post">

        <input type="hidden" id="gatewaysPanel" value="<?= prk_option('chose_panel_sms') ? : '0'; ?>">

        <div class="prk-sms-tab" style="display: none" id="prkSMSContactTab">
                <p class="prk-sms-head-label">ارسال پیامک هنگام تکمیل فرم های شما:
                    <i class="dashicons dashicons-info"
                       title="تمامی فرم های تماس ایجاد شده توسط افزونه Contact7 در لیست زیر قرار داده شده است. شما می توانید با انتخاب هر یک از آن ها، نسبت به ثبت تنظیمات مورد نظر خود اقدام فرمایید. پس از فعال سازی هر یک از فرم ها، در صورت تکمیل فرم توسط کاربر پیامک های مربوطه به ادمین سایت و خود کاربر ارسال خواهد شد."></i>
                </p>
                <div class="contact-form-list">
                    <table class="form-table prk-sms-form-table">
                        <tbody>
                        <?php foreach ($contactForms as $form) {
                            preg_match_all("/\\[(.*?)\\]/", $form->meta_value, $fields);
                            $parameters = "#FieldTypeFiledID#: ";
                            foreach ($fields[1] as $field) {
                                $explodeFields = explode(" ", $field);
                                foreach ($explodeFields as $explodeField) {
                                    if (preg_match('~[\w]-[\d]~', $explodeField)) {
                                        $fieldTypeId = str_replace("-", "", $explodeField);
                                        $parameters .= "<span class='prk-sms-setting-parameter'> #$fieldTypeId# </span>,";
                                    }
                                }
                            }
                            ?>
                            <tr>
                                <td class="form-table-checkbox">
                                    <p class="prk-sms-label"><?= $form->title ?>:</p>
                                </td>
                                <td class="form-table-checkbox">
                                    <input class="form-control prk-sms-setting-checkbox" type="checkbox" data-type="admin"
                                           name="prk_sms_contact_admin_<?= $form->id ?>" <?php if (get_option("prk_sms_contact_admin_{$form->id}_status")) { ?> checked <?php } ?>>
                                    <input type="hidden" name="prk_sms_contact_admin_<?= $form->id ?>_status"
                                           value="<?= get_option("prk_sms_contact_admin_{$form->id}_status") ?>">
                                    <input type="hidden" name="prk_sms_contact_admin_<?= $form->id ?>_mobile"
                                           value="<?= get_option("prk_sms_contact_admin_{$form->id}_mobile") ?>">
                                    <input type="hidden" name="prk_sms_contact_admin_<?= $form->id ?>_template"
                                           value="<?= get_option("prk_sms_contact_admin_{$form->id}_template") ?>">
                                    <input type="hidden" name="prk_sms_contact_admin_<?= $form->id ?>_text"
                                           value="<?= get_option("prk_sms_contact_admin_{$form->id}_text") ?>">
                                    <span name="prk_sms_contact_admin_<?= $form->id ?>_parameter"
                                          class="hidden"><?= $parameters ?></span>
                                    <i class="dashicons dashicons-visibility" data-type="admin"
                                       data-name="prk_sms_contact_admin_<?= $form->id ?>" <?php if (!get_option("prk_sms_contact_admin_{$form->id}_status")) { ?> style="display: none" <?php } ?>></i>
                                    <span>به مدیر</span>
                                </td>

                                <td class="form-table-checkbox">
                                    <input class="form-control prk-sms-setting-checkbox" type="checkbox" data-type="user"
                                           name="prk_sms_contact_user_<?= $form->id ?>" <?php if (get_option("prk_sms_contact_user_{$form->id}_status")) { ?> checked <?php } ?>>
                                    <input type="hidden" name="prk_sms_contact_user_<?= $form->id ?>_status"
                                           value="<?= get_option("prk_sms_contact_user_{$form->id}_status") ?>">
                                    <input type="hidden" name="prk_sms_contact_user_<?= $form->id ?>_mobile"
                                           value="<?= get_option("prk_sms_contact_user_{$form->id}_mobile") ?>">
                                    <input type="hidden" name="prk_sms_contact_user_<?= $form->id ?>_template"
                                           value="<?= get_option("prk_sms_contact_user_{$form->id}_template") ?>">
                                    <input type="hidden" name="prk_sms_contact_user_<?= $form->id ?>_text"
                                           value="<?= get_option("prk_sms_contact_user_{$form->id}_text") ?>">
                                    <span name="prk_sms_contact_user_<?= $form->id ?>_parameter"
                                          class="hidden"><?= $parameters ?></span>
                                    <i class="dashicons dashicons-visibility" data-type="user"
                                       data-name="prk_sms_contact_user_<?= $form->id ?>" <?php if (!get_option("prk_sms_contact_user_{$form->id}_status")) { ?> style="display: none" <?php } ?>></i>
                                    <span>به کاربر</span>
                                </td>

                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <table class="form-table prk-sms-form-table">
                    <tbody>
                    <tr>
                        <td class="form-table-checkbox">
                            <p class="prk-sms-label">ارسال پیامک هنگام ایجاد فرم:
                                <i class="dashicons dashicons-info"
                                   title="با فعالسازی این قابلیت هنگام ایجاد فرم تماس جدید در Contact7، پیامک اطلاع رسانی به مدیر سایت ارسال خواهد شد."></i>
                            </p>
                        </td>
                        <td class="form-table-checkbox">
                            <input class="form-control prk-sms-setting-checkbox" type="checkbox" data-type="admin"
                                   name="prk_sms_contact_create_admin" <?php if (get_option("prk_sms_contact_create_admin_status")) { ?> checked <?php } ?>>
                            <input type="hidden" name="prk_sms_contact_create_admin_status"
                                   value="<?= get_option("prk_sms_contact_create_admin_status") ?>">
                            <input type="hidden" name="prk_sms_contact_create_admin_mobile"
                                   value="<?= get_option("prk_sms_contact_create_admin_mobile") ?>">
                            <input type="hidden" name="prk_sms_contact_create_admin_template"
                                   value="<?= get_option("prk_sms_contact_create_admin_template") ?>">
                            <input type="hidden" name="prk_sms_contact_create_admin_text"
                                   value="<?= get_option("prk_sms_contact_create_admin_text") ?>">
                            <span name="prk_sms_contact_create_admin_parameter" class="hidden">
                                <span class='prk-sms-setting-parameter' title=" شناسه ">#id#</span>,
                                <span class='prk-sms-setting-parameter' title=" عنوان ">#title#</span>
                            </span>
                            <i data-name="prk_sms_contact_create_admin" data-type="admin"
                               class="dashicons dashicons-visibility" <?php if (!get_option("prk_sms_contact_create_admin_status")) { ?> style="display: none" <?php } ?>></i>
                            <span>به مدیر</span>
                        </td>
                        <td class="form-table-checkbox"></td>
                    </tr>
                    <tr>
                        <td class="form-table-checkbox">
                            <p class="prk-sms-label">ارسال پیامک هنگام ویرایش فرم:
                                <i class="dashicons dashicons-info"
                                   title="با فعالسازی این قابلیت هنگام ویرایش هریک از فرم های تماس Contact7، پیامک اطلاع رسانی به همراه جزئیات مورد نیاز به مدیر سایت ارسال خواهد شد."></i>
                            </p>
                        </td>
                        <td class="form-table-checkbox">
                            <input class="form-control prk-sms-setting-checkbox" type="checkbox" data-type="admin"
                                   name="prk_sms_contact_edit_admin" <?php if (get_option("prk_sms_contact_edit_admin_status")) { ?> checked <?php } ?>>
                            <input type="hidden" name="prk_sms_contact_edit_admin_status"
                                   value="<?= get_option("prk_sms_contact_edit_admin_status") ?>">
                            <input type="hidden" name="prk_sms_contact_edit_admin_mobile"
                                   value="<?= get_option("prk_sms_contact_edit_admin_mobile") ?>">
                            <input type="hidden" name="prk_sms_contact_edit_admin_template"
                                   value="<?= get_option("prk_sms_contact_edit_admin_template") ?>">
                            <input type="hidden" name="prk_sms_contact_edit_admin_text"
                                   value="<?= get_option("prk_sms_contact_edit_admin_text") ?>">
                            <span name="prk_sms_contact_edit_admin_parameter" class="hidden">
                            <span class='prk-sms-setting-parameter' title=" شناسه ">#id#</span>,
                                <span class='prk-sms-setting-parameter' title=" عنوان ">#title#</span>
                            </span>
                            <i data-name="prk_sms_contact_edit_admin" data-type="admin"
                               class="dashicons dashicons-visibility" <?php if (!get_option("prk_sms_contact_edit_admin_status")) { ?> style="display: none" <?php } ?>></i>
                            <span>به مدیر</span>
                        </td>
                        <td class="form-table-checkbox"></td>
                    </tr>
                    </tbody>
                </table>
            
                <button type="submit" name="prk_sms_setting_button" value="1"
                        class="prk-sms-setting-button button-primary general">ذخیره کردن
                </button>
            </div>
          
            <div class="prk-sms-tab" id="prkSMSWoocommerceTab">
                <p class="prk-sms-head-label">ارسال پیامک هنگام تغییر وضعیت سفارش:</p>
                <div class="woocommerce-form-list">
                    <table class="form-table prk-sms-form-table">
                        <tbody>
                        <?php foreach ($woocommerceStatuses as $statusKey => $statusValue) {
                            $statusKey = substr($statusKey, 3);
                            ?>
                            <tr>
                                <td class="form-table-checkbox">
                                    <p class="prk-sms-label"><?= $statusValue ?>:</p>
                                </td>
                                <td class="form-table-checkbox">
                                    <input class="form-control prk-sms-setting-checkbox" data-type="admin" type="checkbox"
                                           name="prk_sms_woocommerce_order_admin_<?= $statusKey ?>" <?php if (get_option("prk_sms_woocommerce_order_admin_{$statusKey}_status")) { ?> checked <?php } ?>>
                                    <input type="hidden" name="prk_sms_woocommerce_order_admin_<?= $statusKey ?>_status"
                                           value="<?= get_option("prk_sms_woocommerce_order_admin_{$statusKey}_status") ?>">
                                    <input type="hidden" name="prk_sms_woocommerce_order_admin_<?= $statusKey ?>_mobile"
                                           value="<?= get_option("prk_sms_woocommerce_order_admin_{$statusKey}_mobile") ?>">
                                    <input type="hidden"
                                           name="prk_sms_woocommerce_order_admin_<?= $statusKey ?>_template"
                                           value="<?= get_option("prk_sms_woocommerce_order_admin_{$statusKey}_template") ?>">
                                    <input type="hidden" name="prk_sms_woocommerce_order_admin_<?= $statusKey ?>_text"
                                           value="<?= get_option("prk_sms_woocommerce_order_admin_{$statusKey}_text") ?>">
                                    <span name="prk_sms_woocommerce_order_admin_<?= $statusKey ?>_parameter"
                                          class="hidden">
                                        <span class='prk-sms-setting-parameter' title=" شناسه سفارش ">#orderid#</span>,
                                        <span class='prk-sms-setting-parameter' title=" کد رهگیری ">#trackingcode#</span>,
                                        <span class='prk-sms-setting-parameter' title=" توضیحات " >#description#</span>,
                                        <span class='prk-sms-setting-parameter' title=" روش پرداخت " >#paymentmethod#</span>,
                                        <span class='prk-sms-setting-parameter' title=" وضعیت قبلی " >#oldstatus#</span>,
                                        <span class='prk-sms-setting-parameter' title=" وضعیت جدید ">#newstatus#</span>,
                                        <span class='prk-sms-setting-parameter' title=" قیمت " >#price#</span>,
                                        <span class='prk-sms-setting-parameter' title=" تخفیف  ">#discount#</span>,
                                        <span class='prk-sms-setting-parameter' title=" حمل و نقل ">#shipping#</span>,
                                        <span class='prk-sms-setting-parameter' title=" موارد سفارش ">#items#</span>,
                                        <span class='prk-sms-setting-parameter' title=" تعداد موارد سفارش ">#itemscount#</span>,
                                        <span class='prk-sms-setting-parameter' title=" تعداد محصولات سفارش ">#productscount#</span>,
                                        <span class='prk-sms-setting-parameter' title=" نام کاربر ">#firstname#</span>,
                                        <span class='prk-sms-setting-parameter' title=" نام خانوادگی کاربر ">#lastname#</span>,
                                        <span class='prk-sms-setting-parameter' title=" شرکت ">#company#</span>,
                                        <span class='prk-sms-setting-parameter' title=" آدرس کاربر">#address1#</span>,
                                        <span class='prk-sms-setting-parameter' title=" ادامه آدرس کاربر ">#address2#</span>,
                                        <span class='prk-sms-setting-parameter' title=" شهر ">#city#</span>,
                                        <span class='prk-sms-setting-parameter' title=" استان ">#state#</span>,
                                        <span class='prk-sms-setting-parameter' title=" کد پستی ">#postcode#</span>,
                                        <span class='prk-sms-setting-parameter' title=" کشور ">#country#</span>,
                                        <span class='prk-sms-setting-parameter' title=" ایمیل ">#email#</span>,
                                        <span class='prk-sms-setting-parameter' title=" موبایل ">#phone#</span>
                                        <span class='prk-sms-setting-parameter' title=" کد پیگیری پستی ">#rahgiripost#</span>
                                        <span class='prk-sms-setting-parameter' title=" حمل و نقل پست ">#transportpost#</span>
                                        <span class='prk-sms-setting-parameter' title=" تاریخ ارسال پست ">#senddatepost#</span>
                                    </span>
                                    <i class="dashicons dashicons-visibility" data-type="admin"
                                       data-name="prk_sms_woocommerce_order_admin_<?= $statusKey ?>" <?php if (!get_option("prk_sms_woocommerce_order_admin_{$statusKey}_status")) { ?> style="display: none" <?php } ?>></i>
                                    <span>به مدیر</span>
                                </td>
                                <td class="form-table-checkbox">
                                    <input class="form-control prk-sms-setting-checkbox" type="checkbox"
                                           data-type="order"
                                           name="prk_sms_woocommerce_order_user_<?= $statusKey ?>" <?php if (get_option("prk_sms_woocommerce_order_user_{$statusKey}_status")) { ?> checked <?php } ?>>
                                    <input type="hidden" name="prk_sms_woocommerce_order_user_<?= $statusKey ?>_status"
                                           value="<?= get_option("prk_sms_woocommerce_order_user_{$statusKey}_status") ?>">
                                    <input type="hidden" name="prk_sms_woocommerce_order_user_<?= $statusKey ?>_mobile"
                                           value="<?= get_option("prk_sms_woocommerce_order_user_{$statusKey}_mobile") ?>">
                                    <input type="hidden" name="prk_sms_woocommerce_order_user_<?= $statusKey ?>_template"
                                           value="<?= get_option("prk_sms_woocommerce_order_user_{$statusKey}_template") ?>">
                                    <input type="hidden" name="prk_sms_woocommerce_order_user_<?= $statusKey ?>_text"
                                           value="<?= get_option("prk_sms_woocommerce_order_user_{$statusKey}_text") ?>">
                                    <span name="prk_sms_woocommerce_order_user_<?= $statusKey ?>_parameter"
                                          class="hidden">
                                          <span class='prk-sms-setting-parameter' title=" شناسه سفارش ">#orderid#</span>,
                                        <span class='prk-sms-setting-parameter' title=" کد رهگیری ">#trackingcode#</span>,
                                        <span class='prk-sms-setting-parameter' title=" توضیحات " >#description#</span>,
                                        <span class='prk-sms-setting-parameter' title=" روش پرداخت " >#paymentmethod#</span>,
                                        <span class='prk-sms-setting-parameter' title=" وضعیت قبلی " >#oldstatus#</span>,
                                        <span class='prk-sms-setting-parameter' title=" وضعیت جدید ">#newstatus#</span>,
                                        <span class='prk-sms-setting-parameter' title=" قیمت " >#price#</span>,
                                        <span class='prk-sms-setting-parameter' title=" تخفیف  ">#discount#</span>,
                                        <span class='prk-sms-setting-parameter' title=" حمل و نقل ">#shipping#</span>,
                                        <span class='prk-sms-setting-parameter' title=" موارد سفارش ">#items#</span>,
                                        <span class='prk-sms-setting-parameter' title=" تعداد موارد سفارش ">#itemscount#</span>,
                                        <span class='prk-sms-setting-parameter' title=" تعداد محصولات سفارش ">#productscount#</span>,
                                        <span class='prk-sms-setting-parameter' title=" نام کاربر ">#firstname#</span>,
                                        <span class='prk-sms-setting-parameter' title=" نام خانوادگی کاربر ">#lastname#</span>,
                                        <span class='prk-sms-setting-parameter' title=" شرکت ">#company#</span>,
                                        <span class='prk-sms-setting-parameter' title=" آدرس کاربر">#address1#</span>,
                                        <span class='prk-sms-setting-parameter' title=" ادامه آدرس کاربر ">#address2#</span>,
                                        <span class='prk-sms-setting-parameter' title=" شهر ">#city#</span>,
                                        <span class='prk-sms-setting-parameter' title=" استان ">#state#</span>,
                                        <span class='prk-sms-setting-parameter' title=" کد پستی ">#postcode#</span>,
                                        <span class='prk-sms-setting-parameter' title=" کشور ">#country#</span>,
                                        <span class='prk-sms-setting-parameter' title=" ایمیل ">#email#</span>,
                                        <span class='prk-sms-setting-parameter' title=" موبایل ">#phone#</span>
                                        <span class='prk-sms-setting-parameter' title=" کد پیگیری پستی ">#rahgiripost#</span>
                                        <span class='prk-sms-setting-parameter' title=" حمل و نقل پست ">#transportpost#</span>
                                        <span class='prk-sms-setting-parameter' title=" تاریخ ارسال پست ">#senddatepost#</span>
                                    </span>
                                    <i class="dashicons dashicons-visibility"
                                       data-name="prk_sms_woocommerce_order_user_<?= $statusKey ?>" <?php if (!get_option("prk_sms_woocommerce_order_user_{$statusKey}_status")) { ?> style="display: none" <?php } ?>></i>
                                    <span>به کاربر</span>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <table class="form-table prk-sms-form-table">
                    <tbody>
                    <tr>
                        <td class="form-table-checkbox">
                            <p class="prk-sms-label">ارسال پیامک هنگام ثبت سفارش:</p>
                        </td>
                        <td class="form-table-checkbox">
                            <input class="form-control prk-sms-setting-checkbox" data-type="admin" type="checkbox"
                                   name="prk_sms_woocommerce_new_order_admin" <?php if (get_option("prk_sms_woocommerce_new_order_admin_status")) { ?> checked <?php } ?>>
                            <input type="hidden" name="prk_sms_woocommerce_new_order_admin_status"
                                   value="<?= get_option("prk_sms_woocommerce_new_order_admin_status") ?>">
                            <input type="hidden" name="prk_sms_woocommerce_new_order_admin_mobile"
                                   value="<?= get_option("prk_sms_woocommerce_new_order_admin_mobile") ?>">
                            <input type="hidden" name="prk_sms_woocommerce_new_order_admin_template"
                                   value="<?= get_option("prk_sms_woocommerce_new_order_admin_template") ?>">
                            <input type="hidden" name="prk_sms_woocommerce_new_order_admin_text"
                                   value="<?= get_option("prk_sms_woocommerce_new_order_admin_text") ?>">
                            <span name="prk_sms_woocommerce_new_order_admin_parameter" class="hidden">
                            <span class='prk-sms-setting-parameter' title=" شناسه سفارش ">#orderid#</span>,
                                        <span class='prk-sms-setting-parameter' title=" کد رهگیری ">#trackingcode#</span>,
                                        <span class='prk-sms-setting-parameter' title=" توضیحات " >#description#</span>,
                                        <span class='prk-sms-setting-parameter' title=" روش پرداخت " >#paymentmethod#</span>,
                                        <span class='prk-sms-setting-parameter' title=" وضعیت قبلی " >#oldstatus#</span>,
                                        <span class='prk-sms-setting-parameter' title=" وضعیت جدید ">#newstatus#</span>,
                                        <span class='prk-sms-setting-parameter' title=" قیمت " >#price#</span>,
                                        <span class='prk-sms-setting-parameter' title=" تخفیف  ">#discount#</span>,
                                        <span class='prk-sms-setting-parameter' title=" حمل و نقل ">#shipping#</span>,
                                        <span class='prk-sms-setting-parameter' title=" موارد سفارش ">#items#</span>,
                                        <span class='prk-sms-setting-parameter' title=" تعداد موارد سفارش ">#itemscount#</span>,
                                        <span class='prk-sms-setting-parameter' title=" تعداد محصولات سفارش ">#productscount#</span>,
                                        <span class='prk-sms-setting-parameter' title=" نام کاربر ">#firstname#</span>,
                                        <span class='prk-sms-setting-parameter' title=" نام خانوادگی کاربر ">#lastname#</span>,
                                        <span class='prk-sms-setting-parameter' title=" شرکت ">#company#</span>,
                                        <span class='prk-sms-setting-parameter' title=" آدرس کاربر">#address1#</span>,
                                        <span class='prk-sms-setting-parameter' title=" ادامه آدرس کاربر ">#address2#</span>,
                                        <span class='prk-sms-setting-parameter' title=" شهر ">#city#</span>,
                                        <span class='prk-sms-setting-parameter' title=" استان ">#state#</span>,
                                        <span class='prk-sms-setting-parameter' title=" کد پستی ">#postcode#</span>,
                                        <span class='prk-sms-setting-parameter' title=" کشور ">#country#</span>,
                                        <span class='prk-sms-setting-parameter' title=" ایمیل ">#email#</span>,
                                        <span class='prk-sms-setting-parameter' title=" موبایل ">#phone#</span>
                            </span>
                            <i data-name="prk_sms_woocommerce_new_order_admin" data-type="admin"
                               class="dashicons dashicons-visibility" <?php if (!get_option("prk_sms_woocommerce_new_order_admin_status")) { ?> style="display:none;" <?php } ?>></i>
                            <span>به مدیر</span>
                        </td>
                        <td class="form-table-checkbox">
                            <input class="form-control prk-sms-setting-checkbox" type="checkbox" data-type="order"
                                   name="prk_sms_woocommerce_new_order_user" <?php if (get_option("prk_sms_woocommerce_new_order_user_status")) { ?> checked <?php } ?>>
                            <input type="hidden" name="prk_sms_woocommerce_new_order_user_status"
                                   value="<?= get_option("prk_sms_woocommerce_new_order_user_status") ?>">
                            <input type="hidden" name="prk_sms_woocommerce_new_order_user_mobile"
                                   value="<?= get_option("prk_sms_woocommerce_new_order_user_mobile") ?>">
                            <input type="hidden" name="prk_sms_woocommerce_new_order_user_template"
                                   value="<?= get_option("prk_sms_woocommerce_new_order_user_template") ?>">
                            <input type="hidden" name="prk_sms_woocommerce_new_order_user_text"
                                   value="<?= get_option("prk_sms_woocommerce_new_order_user_text") ?>">
                            <span name="prk_sms_woocommerce_new_order_user_parameter" class="hidden">
                            <span class='prk-sms-setting-parameter' title=" شناسه سفارش ">#orderid#</span>,
                                        <span class='prk-sms-setting-parameter' title=" کد رهگیری ">#trackingcode#</span>,
                                        <span class='prk-sms-setting-parameter' title=" توضیحات " >#description#</span>,
                                        <span class='prk-sms-setting-parameter' title=" روش پرداخت " >#paymentmethod#</span>,
                                        <span class='prk-sms-setting-parameter' title=" وضعیت قبلی " >#oldstatus#</span>,
                                        <span class='prk-sms-setting-parameter' title=" وضعیت جدید ">#newstatus#</span>,
                                        <span class='prk-sms-setting-parameter' title=" قیمت " >#price#</span>,
                                        <span class='prk-sms-setting-parameter' title=" تخفیف  ">#discount#</span>,
                                        <span class='prk-sms-setting-parameter' title=" حمل و نقل ">#shipping#</span>,
                                        <span class='prk-sms-setting-parameter' title=" موارد سفارش ">#items#</span>,
                                        <span class='prk-sms-setting-parameter' title=" تعداد موارد سفارش ">#itemscount#</span>,
                                        <span class='prk-sms-setting-parameter' title=" تعداد محصولات سفارش ">#productscount#</span>,
                                        <span class='prk-sms-setting-parameter' title=" نام کاربر ">#firstname#</span>,
                                        <span class='prk-sms-setting-parameter' title=" نام خانوادگی کاربر ">#lastname#</span>,
                                        <span class='prk-sms-setting-parameter' title=" شرکت ">#company#</span>,
                                        <span class='prk-sms-setting-parameter' title=" آدرس کاربر">#address1#</span>,
                                        <span class='prk-sms-setting-parameter' title=" ادامه آدرس کاربر ">#address2#</span>,
                                        <span class='prk-sms-setting-parameter' title=" شهر ">#city#</span>,
                                        <span class='prk-sms-setting-parameter' title=" استان ">#state#</span>,
                                        <span class='prk-sms-setting-parameter' title=" کد پستی ">#postcode#</span>,
                                        <span class='prk-sms-setting-parameter' title=" کشور ">#country#</span>,
                                        <span class='prk-sms-setting-parameter' title=" ایمیل ">#email#</span>,
                                        <span class='prk-sms-setting-parameter' title=" موبایل ">#phone#</span>
                            </span>
                            <i class="dashicons dashicons-visibility"
                               data-name="prk_sms_woocommerce_new_order_user" <?php if (!get_option("prk_sms_woocommerce_new_order_user_status")) { ?> style="display: none" <?php } ?>></i>
                            <span>به کاربر</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="form-table-checkbox">
                            <p class="prk-sms-label">ارسال پیامک موجودی انبار:</p>
                        </td>
                        <td class="form-table-checkbox">
                            <input class="form-control prk-sms-setting-checkbox" data-type="admin" type="checkbox"
                                   name="prk_sms_woocommerce_stock_admin" <?php if (get_option("prk_sms_woocommerce_stock_admin_status")) { ?> checked <?php } ?>>
                            <input type="hidden" name="prk_sms_woocommerce_stock_admin_status"
                                   value="<?= get_option("prk_sms_woocommerce_stock_admin_status") ?>">
                            <input type="hidden" name="prk_sms_woocommerce_stock_admin_mobile"
                                   value="<?= get_option("prk_sms_woocommerce_stock_admin_mobile") ?>">
                            <input type="hidden" name="prk_sms_woocommerce_stock_admin_template"
                                   value="<?= get_option("prk_sms_woocommerce_stock_admin_template") ?>">

                            <input type="hidden" name="prk_sms_woocommerce_stock_admin_text"
                                   value="<?= get_option("prk_sms_woocommerce_stock_admin_text") ?>">

                            <span name="prk_sms_woocommerce_stock_admin_parameter" class="hidden">
                                <span class='prk-sms-setting-parameter' title=" شناسه ">#id#</span>,
                                <span class='prk-sms-setting-parameter' title=" نام " >#name#</span>,
                                <span class='prk-sms-setting-parameter' title=" تعداد ">#quantity#</span>,
                                <span class='prk-sms-setting-parameter' title=" کم بودن موجودی ">#lowstock#</span>
                            </span>
                            <i data-name="prk_sms_woocommerce_stock_admin" data-type="admin"
                               class="dashicons dashicons-visibility" <?php if (!get_option("prk_sms_woocommerce_stock_admin_status")) { ?> style="display: none" <?php } ?>></i>
                            <span>به مدیر</span>
                        </td>
                        <td class="form-table-checkbox"></td>
                    </tr>

                    <tr>
                        <td class="form-table-checkbox">
                            <p class="prk-sms-label">ارسال پیامک هنگام موجود شدن کالا:</p>
                        </td>
                        <td class="form-table-checkbox"></td>
                        <td class="form-table-checkbox">
                            <input class="form-control prk-sms-setting-checkbox" type="checkbox" data-type="system"
                                   name="prk_sms_woocommerce_inventory_user" <?php if (get_option("prk_sms_woocommerce_inventory_user_status")) { ?> checked <?php } ?>>
                            <input type="hidden" name="prk_sms_woocommerce_inventory_user_status"
                                   value="<?= get_option("prk_sms_woocommerce_inventory_user_status") ?>">
                            <input type="hidden" name="prk_sms_woocommerce_inventory_user_mobile"
                                   value="<?= get_option("prk_sms_woocommerce_inventory_user_mobile") ?>">
                            <input type="hidden" name="prk_sms_woocommerce_inventory_user_template"
                                   value="<?= get_option("prk_sms_woocommerce_inventory_user_template") ?>">
                            <input type="hidden" name="prk_sms_woocommerce_inventory_user_text"
                                   value="<?= get_option("prk_sms_woocommerce_inventory_user_text") ?>">
                            <span name="prk_sms_woocommerce_inventory_user_parameter" class="hidden">
                                <span class='prk-sms-setting-parameter' title=" نام کاربر ">#clientname#</span>,
                                <span class='prk-sms-setting-parameter ' title=" شناسه محصول ">#productid#</span>,
                                <span class='prk-sms-setting-parameter' title=" نام محصول ">#productname#</span>,
                                <span class='prk-sms-setting-parameter' title=" SKU محصول ">#productsku#</span>
                            </span>
                            <i data-name="prk_sms_woocommerce_inventory_user" data-type="system"
                               class="dashicons dashicons-visibility" <?php if (!get_option("prk_sms_woocommerce_inventory_user_status")) { ?> style="display: none" <?php } ?>></i>
                            <span>به کاربر</span>
                        </td>
                    </tr>

                    <tr data-hash-id="remrderPattern" >
                        <td class="form-table-checkbox">
                            <p class="prk-sms-label">ارسال پیامک سفارش پرداخت نشده:</p>
                        </td>
                        <td class="form-table-checkbox"></td>
                        <td class="form-table-checkbox">
                            <input class="form-control prk-sms-setting-checkbox" type="checkbox" data-type="system"
                                   name="prk_sms_woocommerce_reminder_user" <?php if (get_option("prk_sms_woocommerce_reminder_user_status")) { ?> checked <?php } ?>>
                                   
                            <input type="hidden" name="prk_sms_woocommerce_reminder_user_status"
                                   value="<?= get_option("prk_sms_woocommerce_reminder_user_status") ?>">

                            <input type="hidden" name="prk_sms_woocommerce_reminder_user_mobile"
                                   value="<?= get_option("prk_sms_woocommerce_reminder_user_mobile") ?>">

                            <input type="hidden" name="prk_sms_woocommerce_reminder_user_template"
                                   value="<?= get_option("prk_sms_woocommerce_reminder_user_template") ?>">

                            <input type="hidden" name="prk_sms_woocommerce_reminder_user_text"
                                   value="<?= get_option("prk_sms_woocommerce_reminder_user_text") ?>">

                            <span name="prk_sms_woocommerce_reminder_user_parameter" class="hidden">
                                        <span class='prk-sms-setting-parameter' title=" نام کاربر ">#firstname#</span>,
                                        <span class='prk-sms-setting-parameter' title=" نام خانوادگی کاربر ">#lastname#</span>,

                                <span class='prk-sms-setting-parameter' title=" نام محصول ">#productname#</span>,

                                <?php if ($chosen_gateway !== 'melipayamak') { ?>
                                    <span class='prk-sms-setting-parameter' title="لینک سفارشات">>#orderurl#</span>,
                                <?php } ?>


                                <span class='prk-sms-setting-parameter' title=" کد تخفیف ">#coupon#</span>
                            </span>
                            <i data-name="prk_sms_woocommerce_reminder_user" data-type="system"
                               class="dashicons dashicons-visibility" <?php if (!get_option("prk_sms_woocommerce_reminder_user_status")) { ?> style="display: none" <?php } ?>></i>
                            <span>به کاربر</span>
                        </td>
                    </tr>


                    <tr data-hash-id="remcartPattern">
                        <td class="form-table-checkbox">
                            <p class="prk-sms-label">ارسال پیامک سبدخرید رها شده:</p>
                        </td>

                        <td class="form-table-checkbox"></td>

                        <td class="form-table-checkbox">

                            <input class="form-control prk-sms-setting-checkbox" type="checkbox" data-type="system"
                                   name="prk_sms_woocommerce_reminder_user_cart" <?php if (get_option("prk_sms_woocommerce_reminder_user_cart_status")) { ?> checked <?php } ?>>

                            <input type="hidden" name="prk_sms_woocommerce_reminder_user_cart_status"
                                   value="<?= get_option("prk_sms_woocommerce_reminder_user_cart_status") ?>">

                            <input type="hidden" name="prk_sms_woocommerce_reminder_user_cart_mobile"
                                   value="<?= get_option("prk_sms_woocommerce_reminder_user_cart_mobile") ?>">

                            <input type="hidden" name="prk_sms_woocommerce_reminder_user_cart_template"
                                   value="<?= get_option("prk_sms_woocommerce_reminder_user_cart_template") ?>">


                            <input type="hidden" name="prk_sms_woocommerce_reminder_user_cart_text"
                                   value="<?= get_option("prk_sms_woocommerce_reminder_user_cart_text") ?>">

                            <span name="prk_sms_woocommerce_reminder_user_cart_parameter" class="hidden">
                                <span class='prk-sms-setting-parameter' title=" نام کاربر ">#firstname#</span>,
                                <span class='prk-sms-setting-parameter' title=" نام خانوادگی کاربر ">#lastname#</span>,
                                <span class='prk-sms-setting-parameter' title=" نام محصول ">#productname#</span>,

                                <?php if ($chosen_gateway !== 'melipayamak') { ?>
                                    <span class='prk-sms-setting-parameter' title="لینک سبدخرید">#carturl#</span>,
                                <?php } ?>

                                <span class='prk-sms-setting-parameter' title=" کد تخفیف ">#coupon#</span>
                            </span>

                            <i data-name="prk_sms_woocommerce_reminder_user_cart" data-type="system"
                               class="dashicons dashicons-visibility" <?php if (!get_option("prk_sms_woocommerce_reminder_user_cart_status")) { ?> style="display: none" <?php } ?>></i>
                            <span>به کاربر</span>
                        </td>
                    </tr>

                    <tr data-hash-id="ratePattern">
                        <td class="form-table-checkbox">
                            <p class="prk-sms-label">پیامک نقد و بررسی محصولات</p>
                        </td>

                        <td class="form-table-checkbox"></td>

                        <td class="form-table-checkbox">

                            <input class="form-control prk-sms-setting-checkbox" type="checkbox" data-type="system"
                                   name="prk_sms_woocommerce_reminder_user_rate" <?php if (get_option("prk_sms_woocommerce_reminder_user_rate_status")) { ?> checked <?php } ?>>

                            <input type="hidden" name="prk_sms_woocommerce_reminder_user_rate_status"
                                   value="<?= get_option("prk_sms_woocommerce_reminder_user_rate_status") ?>">

                            <input type="hidden" name="prk_sms_woocommerce_reminder_user_rate_mobile"
                                   value="<?= get_option("prk_sms_woocommerce_reminder_user_rate_mobile") ?>">

                            <input type="hidden" name="prk_sms_woocommerce_reminder_user_rate_template"
                                   value="<?= get_option("prk_sms_woocommerce_reminder_user_rate_template") ?>">


                            <input type="hidden" name="prk_sms_woocommerce_reminder_user_rate_text"
                                   value="<?= get_option("prk_sms_woocommerce_reminder_user_rate_text") ?>">

                            <span name="prk_sms_woocommerce_reminder_user_rate_parameter" class="hidden">
                                <span class='prk-sms-setting-parameter' title=" نام کاربر ">#firstname#</span>,
                                <span class='prk-sms-setting-parameter' title=" نام خانوادگی کاربر ">#lastname#</span>,

                                <?php if ($chosen_gateway !== 'melipayamak') { ?>
                                    <span class='prk-sms-setting-parameter'  title="لینک نظر سنجی">#rateurl#</span>,
                                <?php } ?>

                                <span class='prk-sms-setting-parameter' title=" کد تخفیف ">#coupon#</span>
                            </span>

                            <i data-name="prk_sms_woocommerce_reminder_user_rate" data-type="system"
                               class="dashicons dashicons-visibility" <?php if (!get_option("prk_sms_woocommerce_reminder_user_rate_status")) { ?> style="display: none" <?php } ?>></i>
                            <span>به کاربر</span>

                        </td>
                    </tr>

                    <tr >

                        <td class="form-table-checkbox">
                            <p class="prk-sms-label"> پیامک محصول پیشنهاد شگفت انگیز شد خبرم بده:</p>
                        </td>
                        <td class="form-table-checkbox"></td>
                        <td class="form-table-checkbox">
                            <input class="form-control prk-sms-setting-checkbox" type="checkbox" data-type="system"
                                   name="prk_sms_woocommerce_promotion_user" <?php if (get_option("prk_sms_woocommerce_promotion_user_status")) { ?> checked <?php } ?>>

                            <input type="hidden" name="prk_sms_woocommerce_promotion_user_status"
                                   value="<?= get_option("prk_sms_woocommerce_promotion_user_status") ?>">

                            <input type="hidden" name="prk_sms_woocommerce_promotion_user_mobile"
                                   value="<?= get_option("prk_sms_woocommerce_promotion_user_mobile") ?>">
                            <input type="hidden" name="prk_sms_woocommerce_promotion_user_template"
                                   value="<?= get_option("prk_sms_woocommerce_promotion_user_template") ?>">
                            <input type="hidden" name="prk_sms_woocommerce_promotion_user_text"
                                   value="<?= get_option("prk_sms_woocommerce_promotion_user_text") ?>">
                            <span name="prk_sms_woocommerce_promotion_user_parameter" class="hidden">
                            <span class='prk-sms-setting-parameter' title=" نام کاربر ">#clientname#</span>,
                                <span class='prk-sms-setting-parameter ' title=" شناسه محصول ">#productid#</span>,
                                <span class='prk-sms-setting-parameter' title=" نام محصول ">#productname#</span>,
                                <span class='prk-sms-setting-parameter' title=" SKU محصول ">#productsku#</span>
                            </span>
                            <i data-name="prk_sms_woocommerce_promotion_user" data-type="system"
                               class="dashicons dashicons-visibility" <?php if (!get_option("prk_sms_woocommerce_promotion_user_status")) { ?> style="display: none" <?php } ?>></i>
                            <span>به کاربر</span>
                        </td>
                    </tr>

                    <tr data-hash-id="otpPattern">
                        <td class="form-table-checkbox">
                            <p class="prk-sms-label">پیامک ورود/عضویت</p>
                        </td>
                        <td class="form-table-checkbox"></td>
                        <td class="form-table-checkbox">
                            <input class="form-control prk-sms-setting-checkbox" type="checkbox" data-type="system"
                                   name="prk_sms_otp_user" <?php if (get_option("prk_sms_otp_user_status")) { ?> checked <?php } ?>>
                            <input type="hidden" name="prk_sms_otp_user_status"
                                   value="<?= get_option("prk_sms_otp_user_status") ?>">
                            <input type="hidden" name="prk_sms_otp_user_mobile"
                                   value="<?= get_option("prk_sms_otp_user_mobile") ?>">
                            <input type="hidden" name="prk_sms_otp_user_template"
                                   value="<?= get_option("prk_sms_otp_user_template") ?>">
                            <input type="hidden" name="prk_sms_otp_user_text"
                                   value="<?= get_option("prk_sms_otp_user_text") ?>">
                            <span name="prk_sms_otp_user_parameter" class="hidden">
                            <span class='prk-sms-setting-parameter'title=" کد تایید ">#code#</span>
                            </span>
                            <i data-name="prk_sms_otp_user" data-type="system"
                               class="dashicons dashicons-visibility" <?php if (!get_option("prk_sms_otp_user_status")) { ?> style="display: none" <?php } ?>></i>
                            <span>به کاربر</span>
                        </td>
                    </tr>

                    <tr data-hash-id="promo-guide">
                        <td class="form-table-checkbox">
                            <p class="prk-sms-label">تنظیم پیامک خوش‌آمدگویی خبرنامه پارس کالا</p>
                        </td>
                        <td class="form-table-checkbox"></td>
                        <td class="form-table-checkbox">
                            <input class="form-control prk-sms-setting-checkbox" type="checkbox" data-type="system"
                                   name="prk_sms_newsletter_user" <?php if (get_option("prk_sms_newsletter_user_status")) { ?> checked <?php } ?>>
                            <input type="hidden" name="prk_sms_newsletter_user_status"
                                   value="<?= get_option("prk_sms_newsletter_user_status") ?>">
                            <input type="hidden" name="prk_sms_newsletter_user_mobile"
                                   value="<?= get_option("prk_sms_newsletter_user_mobile") ?>">
                            <input type="hidden" name="prk_sms_newsletter_user_template"
                                   value="<?= get_option("prk_sms_newsletter_user_template") ?>">
                            <input type="hidden" name="prk_sms_newsletter_user_text"
                                   value="<?= get_option("prk_sms_newsletter_user_text") ?>">
                            <span name="prk_sms_newsletter_user_parameter" class="hidden">
                                <span class='prk-sms-setting-parameter' title=" نام کاربر ">#clientname#</span>
                            </span>
                            <i data-name="prk_sms_newsletter_user" data-type="system"
                               class="dashicons dashicons-visibility" <?php if (!get_option("prk_sms_newsletter_user_status")) { ?> style="display: none" <?php } ?>></i>
                            <span>به کاربر</span>
                        </td>
                    </tr>

                    </tbody>
                </table>
         
                <button type="submit" name="prk_sms_setting_button" value="1"
                        class="prk-sms-setting-button button-primary general">ذخیره کردن
                </button>
            </div>
      
        </form>
        <div id="prkSMSModal" class="prk-sms-modal">
            <div class="prk-sms-modal-content">
                <input type="hidden" id="prkSMSModalType">
                <span class="prk-sms-modal-close" onclick="hideprkSMSModal()">&times;</span>
                <p class="prk-sms-label title-modal" id="prkSMSModalMobileLabel">شماره مدیران را وارد نمایید:</p>
                <input type="tel" class="prk-sms-form-control prk-sms-modal-form-control" id="prkSMSModalMobile"
                       placeholder="0911*******,0912*******,0913*******" required>
                <small class="prk-sms-form-text" id="prkSMSModalMobileSmall"></small>
                 <br>

                <small class="prk-sms-form-text prk-sms-form-error" id="prkSMSModalMobileError"></small>
           
                
                <div id="prkSMSModalMobileVerify" >
                    <p class="prk-sms-label">شماره پترن خود را وارد نمایید:</p>
                    <input type="text" class="prk-sms-form-control prk-sms-modal-form-control" dir="ltr"
                           id="prkSMSModalTemplate" placeholder="12345***" min="0" value="0" required>
                    <small class="prk-sms-form-text">
                        شماره پترنی که در سامانه پیامکی ثبت کرده اید را وارد نمایید.
                    </small>
                    <br>

                    <small class="prk-sms-form-text prk-sms-form-error" id="prkSMSModalTemplateError">
                        *شماره قالب وارد شده صحیح نمی باشد
                    </small>
                </div>
                <div id="prkSMSModalMobileBulk">
                    <p class="prk-sms-label">متن پیامک را وارد نمایید:</p>
                    <?php
                    $prkSMSModalMobileBulkRequired = true;
                    if (!empty(PRKSMSAppClass::prk_opt('chose_panel_sms')) && PRKSMSAppClass::prk_opt('chose_panel_sms') == 'smsir'){
                        $prkSMSModalMobileBulkRequired = false;
                    }
                    ?>

                    <textarea rows="8" class="prk-sms-form-control prk-sms-modal-form-control" id="prkSMSModalText"
                              lang="fa-IR" charset="utf-8" dir="rtl" placeholder="<?php echo (!$prkSMSModalMobileBulkRequired ? 'برای پنل پیامکی sms.ir نیازی به ثبت پارامترها در این بخش نیست.':'سلام، *****');
                               ?>"
                              <?php echo ($prkSMSModalMobileBulkRequiredrequired ? "required":'')?>></textarea>

                              <div id="prkSMSLivePreview" class="prk-sms-preview-box">

                                <span class="Preview-title">پیش‌نمایش الگوی پیام
                                    <i class="dashicons dashicons-info" title="در سامانه پیامکی خود یک پترن (الگو) بسازید و این متن را قرار دهید."></i>
                                </span>
                                 
                                <div class="text"></div>
                                <i class="ri-file-copy-line copy-btn" title="کپی پیش‌نمایش"></i>
                                <span class="copied-msg" style="display:none;">کپی شد!</span>
                            </div>

                    <small class="prk-sms-form-text">
                        طبق پارامترهای زیر متن خود را تکمیل کنید.
                    </small>
                </div>
                <p class="prk-sms-label">پارامترهای مورد قبول جهت استفاده در پیامک بدین صورت می باشد:</p>
                <p class="prk-sms-label" id="prkSMSTemplateParameter" dir="ltr"></p>
                
                <p class="prk-sms-modal-button">
                    <button type="button" id="prkSMSModalButton" class="prk-sms-setting-button button-primary"
                            onclick="saveprkSMSModal()">ثبت
                    </button>
                </p>
            </div>
        </div>
    </div>
                </div>
                </div>
