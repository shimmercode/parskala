<?php defined('ABSPATH') || exit;

require __DIR__."/bootsrap/bootstrap.php";


class PRKSMS
{
    protected static $_instance = null;

    const NAMESPACE_GATEWAYS_CLASSES = "PRKSMS\Gateways\Classes\\";

    public $username;

    public $password;

    public $pattern_id;

    public $from;

    public $api_key;

    public $sms_count_code;

    private  $sms_expire_code;

    private  $sms_code_pattern_code;

    private  $text_msg;

    private  $chose_panel_sms;

    private  $geteway;
    
    private $patterns;

    public function __construct()
    {

        $this->username = $this->prk_opt('gateway_sms_username');

        $this->password = $this->prk_opt('gateway_sms_password');

        $this->patterns['login'] = $this->prk_opt('gateway_sms_pattern_code');

        $this->patterns['instock_product'] = $this->prk_opt('gateway_sms_pattern_code_instock_product');

        $this->patterns['amazing_product'] = $this->prk_opt('gateway_sms_pattern_code_amazing_product');

        $this->from = $this->prk_opt('gateway_sms_panel_number');

        $this->text_msg = $this->prk_opt('gateway_sms_text_msg');

        $this->api_key = $this->prk_opt('gateway_sms_panel_api_key');

        $this->chose_panel_sms = $this->prk_opt('chose_panel_sms');
        if($this->chose_panel_sms == 'farazsms'){
            $this->chose_panel_sms = 'ippanel';
        }
       

        $gateway_class_with_namespace=self::NAMESPACE_GATEWAYS_CLASSES.$this->chose_panel_sms;

        if(!empty($this->chose_panel_sms) and is_string($this->chose_panel_sms) and class_exists($gateway_class_with_namespace)){

            $this->geteway = new $gateway_class_with_namespace($this);
      
        }
        

    }


     function sendPattern($data){

        if(isset($data['pattern']['name']) && isset($this->patterns[$data['pattern']['name']])){

            $this->pattern_id = $this->patterns[$data['pattern']['name']];

            if(!empty($this->pattern_id)){

                return $this->geteway->sendPattern($data);

            }

        }
       
    }


    public function prk_opt($prk_id_opt)
    {
        $prk_option = get_option('prk_option');

        $prk_echo_opt = '';

        if (!empty($prk_option[$prk_id_opt])):

            $prk_echo_opt = $prk_option[$prk_id_opt];

        endif;

        return $prk_echo_opt;
    }

}