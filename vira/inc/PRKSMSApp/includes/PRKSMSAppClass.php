<?php

if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

require __DIR__."/bootstrap/bootstrap.php";

/**
 * @class PRKSMSAppClass
 */
class PRKSMSAppClass
{

    const NAMESPACE_GATEWAYS_CLASSES = "PRKSMSApp\Gateways\Classes\\";

    private static $instance;

    public $username;

    public $password;

    public $pattern_id;

    public $from;

    public $api_key;

    public $sms_text;

    public $actions_parameters;

    public $sms_count_code;

    public $phonebook_id;


    private  $sms_expire_code;

    private  $sms_code_pattern_code;

    private  $text_msg;

    private  $chose_panel_sms;

    private  $geteway;
    
    private $patterns;


    const ACTIONS = [
        '/prk_sms_woocommerce_promotion_user_text/',
        '/prk_sms_woocommerce_inventory_user_text/',
        '/prk_sms_woocommerce_new_order_user_text/',
        '/prk_sms_woocommerce_new_order_admin_text/',
        '/prk_sms_woocommerce_stock_admin_text/',
        '/prk_sms_woocommerce_order_user_pending_text/',
        '/prk_sms_woocommerce_order_user_processing_text/',
        '/prk_sms_woocommerce_order_user_shipped_text/',
        '/prk_sms_woocommerce_order_user_on-hold_text/',
        '/prk_sms_woocommerce_order_user_completed_text/',
        '/prk_sms_woocommerce_order_user_cancelled_text/',
        '/prk_sms_woocommerce_order_user_refunded_text/',
        '/prk_sms_woocommerce_order_user_failed_text/',
        '/prk_sms_woocommerce_order_user_draft_text/',
        '/prk_sms_woocommerce_order_admin_pending_text/',
        '/prk_sms_woocommerce_order_admin_processing_text/',
        '/prk_sms_woocommerce_order_admin_shipped_text/',
        '/prk_sms_woocommerce_order_admin_on-hold_text/',
        '/prk_sms_woocommerce_order_admin_completed_text/',
        '/prk_sms_woocommerce_order_admin_cancelled_text/',
        '/prk_sms_woocommerce_order_admin_refunded_text/',
        '/prk_sms_woocommerce_order_admin_failed_text/',
        '/prk_sms_woocommerce_order_admin_draft_text/',
        '/prk_sms_otp_user_text/',
        '/prk_sms_newsletter_user_text/',
        '/prk_sms_contact_edit_admin_text/',
        '/prk_sms_contact_create_admin_text/',
        '/prk_sms_contact_user_[0-9]+_text/',
        '/prk_sms_contact_admin_[0-9]+_text/'
        
    ];

    public static function get_instance($actions_parameters=null) {
       
        if ( is_null( self::$instance ) ) {
            self::$instance = new self($actions_parameters);
        }
		
		return self::$instance;
	}

    public function __construct($actions_parameters=null)
    {

        $this->username = self::prk_opt('gateway_sms_username');

        $this->password = self::prk_opt('gateway_sms_password');

        $this->patterns['login'] = self::prk_opt('gateway_sms_pattern_code');

        $this->actions_parameters = $actions_parameters;

        $this->sms_text = !is_null($actions_parameters) ? get_option($actions_parameters["name"]) : null;

        $this->patterns['instock_product'] = self::prk_opt('gateway_sms_pattern_code_instock_product');

        $this->patterns['amazing_product'] = self::prk_opt('gateway_sms_pattern_code_amazing_product');

        $this->from = self::prk_opt('gateway_sms_panel_number');

        $this->text_msg = self::prk_opt('gateway_sms_text_msg');

        $this->api_key = self::prk_opt('gateway_sms_panel_api_key');
        
        $this->phonebook_id = self::prk_opt('prk_sms_phonebook_id');

        $this->chose_panel_sms = self::prk_opt('chose_panel_sms');
        if($this->chose_panel_sms == 'farazsms'){
            $this->chose_panel_sms = 'ippanel';
        }
       

        $gateway_class_with_namespace=self::NAMESPACE_GATEWAYS_CLASSES.$this->chose_panel_sms;

        if(!empty($this->chose_panel_sms) and is_string($this->chose_panel_sms) and class_exists($gateway_class_with_namespace)){

            
            $this->geteway = new $gateway_class_with_namespace($this);
            
      
        }
        

    }




    public static function __callStatic($method, $parameters){
        
      if (!is_array($parameters)) {
            $parameters = [];
      }
        
      if (is_array($parameters)) {
          
         if (method_exists(__CLASS__, $method)) {

            $matches = false;
            foreach (self::ACTIONS as $pattern)
            {
                if (is_array($parameters[0])){
                if (preg_match($pattern,$parameters[0]["name"]))
                {
                    $matches = true;
                } } 
            }

            if(is_array($parameters) && !empty($parameters) && isset($parameters[0]["name"]) && $matches){
                return call_user_func_array(array(new self($parameters[0]),$method),$parameters);
            }else{
            
                return call_user_func_array(array(new self(),$method),$parameters);
            }

         }
         
      }

    }


    private function sendVerifySMS($parameters, $templateId, $mobile)
    {
        
      if (!is_array($parameters)) {
            $parameters = [];
      }

       return $this->geteway->sendVerifySMS($parameters, $templateId, $mobile);

    }

    private function sendBulkSMS($text, $mobiles)
    {

       return $this->geteway->sendBulkSMS($text, $mobiles);

    }


    private function addNumberInPhonebook($mobile)
    {

       return $this->geteway->addNumberInPhonebook($mobile);

    }

    private function getCredit()
    {
        return $this->geteway->getCredit();

    }

    private function getSendReport()
    {
        return $this->geteway->getSendReport();

    }

    public static final function saveLog($data, $force = false){
		date_default_timezone_set('Asia/Tehran');
		global $wpdb;
		$table_name = $wpdb->prefix . 'prk_sms_app_log';
	

		switch ($data->status){
			case 0:
			case 12:
			case 20:
				$title = 'خطای سرور';
				break;
			case 13:
			case 14:
			case 102:
				$title = 'خطای حساب کاربری';
				break;
			default:
				$title = 'خطای اطلاعات';
				break;
		}

		$data = [
			'id'=> NULL,
			'title' => $title,
			'message' => $data->message,
			'status' => $data->status,
			'created_at' => date("Y/m/d H:i:s"),
		];

		if ($wpdb->insert(
			$table_name,
			$data,
			[
				'%d',
				'%s',
				'%s',
				'%d',
				'%s'
			]
		)) return;

	}

    public static final function getLog(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'prk_sms_app_log';
		$result = $wpdb->get_results("SELECT * FROM `$table_name` ORDER BY `id` ASC ");

		return $result;
	}

	public static final function getInventoryLog(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'prk_sms_app_notifications';
		$table_products = $wpdb->prefix . 'wp_posts';
		$result = $wpdb->get_results("SELECT * FROM `wp_prk_sms_app_notifications` AS notify
								    LEFT JOIN wp_posts as p ON p.ID = notify.product_id AND p.post_type = 'product'
									WHERE type = 'inventory' ORDER BY notify.id ASC ;");

		return $result;
	}

	public static final function getPromotionLog(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'prk_sms_app_notifications';
		$table_products = $wpdb->prefix . 'wp_posts';
		$result = $wpdb->get_results("SELECT * FROM `wp_prk_sms_app_notifications` AS notify
								    LEFT JOIN wp_posts as p ON p.ID = notify.product_id AND p.post_type = 'product'
									WHERE type = 'promotion' ORDER BY notify.id ASC ;");

		return $result;
	}

    


    public static function prk_opt($prk_id_opt)
    {
        $prk_option = get_option('prk_option');

        $prk_echo_opt = '';

        if (!empty($prk_option[$prk_id_opt])):

            $prk_echo_opt = $prk_option[$prk_id_opt];

        endif;

        return $prk_echo_opt;
    }





}
