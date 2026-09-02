<?php namespace PRKSMS\Gateways\Classes;

use PRKSMS\Gateways\Interfaces\SMSInterface;

class Ippanel implements SMSInterface{

    const API_URL = 'https://ippanel.com/';

    private $prk_getways_sms_options;

    private $username;

    private $password;

    private $from;

    public function __construct($prk_getways_options)
    {
        $this->prk_getways_sms_options = $prk_getways_options;

        $this->username = $this->prk_getways_sms_options->username;

        $this->password = html_entity_decode($this->prk_getways_sms_options->password);

        $this->from = $this->prk_getways_sms_options->from;

    }

    public function sendPattern($data)
    {

        $to = $data['to'];

        $pattern=$data['pattern'];

        $pattern['id']=$this->prk_getways_sms_options->pattern_id;

        $input_data = [];

        foreach($pattern['params'] as $p_item){

            $input_data["{$p_item['name']}"] = $p_item['value'];

        }

        $url = self::API_URL . "patterns/pattern?username=" . $this->username . "&password=" . urlencode($this->password) . "&from={$this->from}&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code={$pattern['id']}";
       
        $handler = curl_init($url);

        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);

        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");

        $response = curl_exec($handler);

        curl_close($handler);
        
        return intval($response) ? array('success' => true) : '0';

    }


}