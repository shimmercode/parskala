<?php namespace PRKSMS\Gateways\Classes;

use PRKSMS\Gateways\Interfaces\SMSInterface;

class Melipayamak implements SMSInterface{

    const API_URL = 'https://rest.payamak-panel.com/api/';

    private $prk_getways_sms_options;

    private $username;

    private $password;

    public function __construct($prk_getways_options)
    {
        $this->prk_getways_sms_options = $prk_getways_options;

        $this->username = $this->prk_getways_sms_options->username;

        $this->password = html_entity_decode($this->prk_getways_sms_options->password);
    }

    public function sendPattern($data)
    {

        if (empty($data['to']) || empty($data['pattern'])) {

            error_log("sms parameter check");

            return '0';
        }

        $pattern=$data['pattern'];

        $pattern['id']=$this->prk_getways_sms_options->pattern_id;

        $p_items="";

        foreach($pattern['params'] as $p_item){
            $p_items .= "{$p_item['value']};";

        }

        $param = array(
            'username' => $this->username,
            'password' => $this->password,
            'to' => $data['to'],
            'bodyId' => $pattern['id'],
            'text' => rtrim($p_items,";")
        );
      
        $post_data = http_build_query($param);

        $handler = curl_init(self::API_URL.'SendSMS/BaseServiceNumber');

        curl_setopt($handler, CURLOPT_HTTPHEADER, array(
            'content-type' => 'application/x-www-form-urlencoded'
        ));

        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handler, CURLOPT_POST, true);
        curl_setopt($handler, CURLOPT_POSTFIELDS, $post_data);

        $response = json_decode(curl_exec($handler));

        curl_close($handler);

        if ($response->RetStatus == 1):
            return array('success' => true);
        else:
            return '0';
        endif;

    }




   

}