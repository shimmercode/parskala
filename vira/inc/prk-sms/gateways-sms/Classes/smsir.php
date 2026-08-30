<?php namespace PRKSMS\Gateways\Classes;

use PRKSMS\Gateways\Interfaces\SMSInterface;

class SMSIR implements SMSInterface{

    const API_URL = 'https://api.sms.ir/v1/';

    private $prk_getways_sms_options;
    
    private $api_key;

    public function __construct($prk_getways_options)
    {
        $this->prk_getways_sms_options = $prk_getways_options;

        $this->api_key = $this->prk_getways_sms_options->api_key;


    }

    public function sendPattern($data)
    {


        $pattern=$data['pattern'];

        $pattern['id']=(int)($this->prk_getways_sms_options->pattern_id);

        foreach($pattern['params'] as $p_item){
            $p_item["value"] = mb_substr($p_item["value"],0,25);
            $parameters[]=(object)$p_item;
        }

        $postFields = json_encode([
            "mobile"     => $data['to'],
            "templateId" =>$pattern['id'],
            "parameters" => $parameters
        ]);
       

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => self::API_URL . "send/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_SSL_VERIFYHOST=>0,
            CURLOPT_SSL_VERIFYPEER=>0,
            CURLOPT_POSTFIELDS     => $postFields,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'x-api-key:' . $this->api_key,
            ],
        ]);

        try {
            $response = json_decode(curl_exec($curl));
            
            curl_close($curl);
        //    var_dump($response);
        //    die;
            if ($response->status == 1 && $response->message=="موفق"):
                return array('success' => true);
            else:
                return '0';
            endif;
        } catch (Exeption $e) {
            return false;
        }

    }


    
}