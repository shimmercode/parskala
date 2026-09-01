<?php

if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

add_action('admin_menu', 'prkSMSAppAdmin',11);
add_action("wp_ajax_prk_sms_submit_settings", "prk_sms_submit_settings");
add_action("wp_ajax_nopriv_prk_sms_submit_settings", "prk_sms_submit_settings");
function prk_sms_submit_settings() {

        if (isset($_POST["security"])) {
            if (!wp_verify_nonce( $_POST['security'], "prk_sms_submit_settings_nonce")) {
                $error = "ورودی های فرم تنظیمات نامعتبر می باشد.";
                echo json_encode(['success'=>false,"error"=>$error]);
                die;
            }else{
                parse_str($_POST['data'], $output);
                foreach ($output as $key => $post) {
                    if (((strpos($key, 'prk_sms_') === 0)) && (strlen(trim($post)))) {
                        update_option($key, $post);
                    } else {
                        delete_option($key);
                    }
                }
                echo json_encode(['success'=>true,"message"=>"تنظیمات ذخیره شد."]);
                die;
            }
 
            
        }
    

}

add_action('admin_enqueue_scripts', function ($hook) {

    // بررسی اینکه فقط در صفحه تنظیمات پیامک اجرا شود
    if (isset($_GET['page']) && $_GET['page'] === 'PRKSMSApp-setting') {
        wp_enqueue_style('tourguide-css', 'https://unpkg.com/@sjmc11/tourguidejs/dist/css/tour.min.css');
        wp_enqueue_script('tourguide-js', 'https://unpkg.com/@sjmc11/tourguidejs/dist/tour.js', [], null, true);
    }

});



function prk_sms_render_log_page() {
	$logs = PRKSMSAppClass::getLog();

	echo '<div class="wrap"><h2>لاگ پیامک‌ها</h2>';
	if (empty($logs)) {
		echo '<p>لاگی برای نمایش وجود ندارد.</p></div>';
		return;
	}

	echo '<table class="widefat fixed striped">';
	echo '<thead><tr><th>#</th><th>عنوان</th><th>متن</th><th>وضعیت</th><th>تاریخ</th></tr></thead><tbody>';
	foreach ($logs as $log) {
		echo "<tr>
			<td>{$log->id}</td>
			<td>{$log->title}</td>
			<td>{$log->message}</td>
			<td>{$log->status}</td>
			<td>{$log->created_at}</td>
		</tr>";
	}
	echo '</tbody></table></div>';
}



add_action("wp_ajax_prk_sms_test_send", "prk_sms_test_send");
function prk_sms_test_send() {


    
         $errors = [];
        if (isset($_POST["security"])) {
            parse_str($_POST['data'], $output);
            if(trim($output["prk_sms_text"]) ==''){
                $errors[] = 'متن پیام نمی تواند خالی باشد.';
            }

            if(trim($output["prk_sms_mobile"]) ==''){
                $errors[] = 'شماره موبایل نمی واند خالی باشد';
            }

            if(!empty($errors)){
                $print_error = '';
                foreach($errors as $error){
                    $print_error .= $error.'<br>';
                }   
                echo json_encode(['success'=>false,"error"=>$print_error]);
                die;
            }

     
            $sms = PRKSMSAppClass::sendBulkSMS($output["prk_sms_text"], [$output["prk_sms_mobile"]]);

            if (is_object($sms) && isset($sms->status) && $sms->status == 1) {
                echo json_encode(['success' => true, 'message' => 'ارسال پیامک با موفقیت انجام شد.']);
                wp_die(); // die یا exit فرق نداره ولی بهتره wp_die
            } else {
                $error_message = (is_object($sms) && isset($sms->message)) ? $sms->message : 'پاسخی از سرور دریافت نشد یا ارسال با خطا مواجه شد.';
                echo json_encode(['success' => false, 'error' => $error_message]);
                wp_die();
            }

        }
    

}



/**
 * @return void
 */
function prkSMSAppAdminMain()
{
    include dirname(__FILE__) . '/templates/main.php';
}

/**
 * @return void
 */
function prkSMSAppAdminSetting()
{
    include dirname(__FILE__) . '/templates/settings.php';
}

/**
 * @return void
 */
function prkSMSAppAdminTest()
{
    include dirname(__FILE__) . '/templates/test.php';
}

/**
 * @return void
 */
function prkSMSAppAdminSend()
{
    include dirname(__FILE__) . '/templates/send.php';
}

/**
 * @return void
 */
function prkSMSAppAdminReceive()
{
    include dirname(__FILE__) . '/templates/receive.php';
}

/**
 * @return void
 */
function prkSMSAppAdminLog()
{
    include dirname(__FILE__) . '/templates/log.php';
}

/**
 * @return void
 */
function prkSMSAppAdminInventory()
{
    include dirname(__FILE__) . '/templates/inventory.php';
}

/**
 * @return void
 */
function prkSMSAppAdminPromotion()
{
    include dirname(__FILE__) . '/templates/promotion.php';
}


