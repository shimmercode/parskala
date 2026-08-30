<?php

add_action("init","init_shortcode");
add_action( 'init', 'registerFrontAssets' );
add_action("wp_ajax_prk_sms_newsletter", "prk_sms_newsletter");
add_action("wp_ajax_nopriv_prk_sms_newsletter", "prk_sms_newsletter");

function registerFrontAssets(){
    $url = get_template_directory_uri().'/inc/PRKSMSApp/includes/templates/assets/';

    wp_register_script( 'prk_sms_script_front', $url . 'js/customprkscript.front.js', array('jquery') );
    wp_localize_script( 'prk_sms_script_front', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'prk_sms_script_front' );

}


function init_shortcode()
{
   
    add_shortcode('prk_sms_newsletter', function(){
        $nonce = wp_create_nonce("prk_sms_newsletter_nonce");
        echo '<form class="mail-foot prk_sms_newsletter_form">
        <input type="text" data-nonce="'.$nonce.'" class="prk_sms_newsletter_mobile" name="prk_sms_newsletter_mobile" placeholder="شماره موبایل خود را وارد نمایید.">
        <button class="submit_newsletter_form" type="submit">ثبت</button>
        </form>';

    });


}



function prk_sms_newsletter() {
    global $product, $wpdb, $table_prefix;
    if (isset($_POST["nonce"],$_POST["newsletter_mobile"]) && $_POST["nonce"] && $_POST["newsletter_mobile"]) {
        $newsletter_mobile = $_POST["newsletter_mobile"];
        if (!wp_verify_nonce( $_POST['nonce'], "prk_sms_newsletter_nonce")) {
            $error = "ورودی های فرم خبرنامه نامعتبر می باشد.";
            echo $error;
            exit;
        } elseif (!preg_match("/^09[0-9]{9}$/", $newsletter_mobile)) {
            $error = "شماره موبایل وارد شده نامعتبر است.";
        }else {
            $app_newsletter = $wpdb->get_var($wpdb->prepare("SELECT `id` FROM `{$table_prefix}prk_sms_app_newsletter` WHERE `mobile` = '%d' AND `active` = '1'", $newsletter_mobile));
            if (!is_null($app_newsletter)) {
                $error = "شماره موبایل شما قبلا ثبت شده است.";
                // send_message_to_subscriber($newsletter_mobile);
                // PRKSMSAppClass::addNumberInPhonebook($newsletter_mobile);
            }
        }
    
        if (!isset($error)) {
            $table = $table_prefix . 'prk_sms_app_newsletter';
            $data = [
                'mobile'     => $newsletter_mobile
            ];
            $format = ['%d'];
            $wpdb->insert($table, $data, $format);
    
            if (!$wpdb->insert_id) {
                $error = "ذخیره سازی اطلاعات با مشکل مواجه گردید.";
            } else {
                $message = "اطلاعات شما با موفقیت ذخیره سازی شد.";
            }
        }
    }



    if( empty($error)){
        send_message_to_subscriber($newsletter_mobile);
        $response = PRKSMSAppClass::addNumberInPhonebook($newsletter_mobile);
        // if($response->data['added'] == 1){
        //     $message = "شماره شما با موفقیت ذخیره شد.";
        // }elseif($response->data['existences'] == 1){
        //     $message = "شماره شما قبلا ثبت شده است.";
        // }elseif($response->data['errors'] == 1){
        //     $error = "خطای غیر منتظره رخ داده است";
        // }
        echo json_encode(['status'=>true,'message'=>$message]);
        die;
    }else{
        echo json_encode(['status'=>false,'message'=>$error]);
        die;
    }


    


}

function send_message_to_subscriber($newsletter_mobile){

    if ($templateID = get_option("prk_sms_newsletter_user_template")) {
        $parameters = ["name"=>"prk_sms_newsletter_user_text",
        "params"=>[
            (object)[
                "name"  => "clientname",
                "value" => $newsletter_mobile
            ]
          
        ]];
        // var_dump($parameters);
        // die;
        $payamak = PRKSMSAppClass::sendVerifySMS($parameters, $templateID, $newsletter_mobile);
    
    } else {
        $text = get_option("prk_sms_newsletter_user_text");
        $text = str_replace("#clientname#", $newsletter_mobile, $text);
        // var_dump($text);
        // die;
        $payamak = PRKSMSAppClass::sendBulkSMS($text, [$newsletter_mobile]);
    
    }

}