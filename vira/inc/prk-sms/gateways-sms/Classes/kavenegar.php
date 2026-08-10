<?php namespace PRKSMS\Gateways\Classes;

use PRKSMS\Gateways\Interfaces\SMSInterface;

class Kavenegar implements SMSInterface {

    const API_URL = "http://api.kavenegar.com/v1/";

    private $prk_getways_sms_options;
    
    private $api_key;
 
    public function __construct($prk_getways_options)
    {
        $this->prk_getways_sms_options = $prk_getways_options;

        $this->api_key = $this->prk_getways_sms_options->api_key;

    }

    function sendPattern($data)
    {

        $to = $data['to'];

        $pattern=$data['pattern'];

        $pattern['id']=$this->prk_getways_sms_options->pattern_id;
        $param_value_string =$pattern['params'][0]['value'];
        $param_value_arr = explode(" ",$param_value_string);
        if(count($param_value_arr) > 9){
            $param_value_string=implode(" ",array_slice($param_value_arr,0,9))."...";
        }

        $tokens="&token=.&token20=".urlencode($param_value_string);

        // for($i=1;$i<3;$i++){
        //     if(isset($pattern['params'][$i])){
        //         $tokens.="&token{($i+1)}=".$pattern['params'][$i]['value'];
        //     }
        // }


        $url = self::API_URL .  $this->api_key . "/verify/lookup.json?receptor=" . $to . $tokens . "&template={$pattern['id']}";

        $handler = curl_init($url);

        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "GET");

        $response = json_decode(curl_exec($handler));

        curl_close($handler);

        if ($response->return->status == 200):
            return array('success' => true);
        else:
            return '0';
        endif;
    }


}