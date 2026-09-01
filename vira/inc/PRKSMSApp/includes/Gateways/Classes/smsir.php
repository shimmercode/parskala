<?php namespace PRKSMSApp\Gateways\Classes;

use PRKSMSApp\Gateways\Interfaces\SMSInterface;

class SMSIR implements SMSInterface{

    const API_URL = 'https://api.sms.ir/v1/';

    private $from;

    private $prk_getways_sms_options;
    
    private $api_key;

    private static $instance;


        /**
     * @type array
     */
    const STATES = [
        1 => "رسیده به گوشی",
        2 => "نرسیده به گوشی",
        3 => "پردازش در مخابرات",
        4 => "نرسیده به مخابرات",
        5 => "رسیده به مخابرات",
        6 => "خطا",
        7 => "لیست سیاه",
    ];

    public static function get_instance($prk_getways_options) {
       
        if ( is_null( self::$instance ) ) {
            self::$instance = new self($prk_getways_options);
        }
		
		return self::$instance;
	}

    public function __construct($prk_getways_options)
    {
        $this->prk_getways_sms_options = $prk_getways_options;

        $this->api_key = $this->prk_getways_sms_options->api_key;

        $this->from = $this->prk_getways_sms_options->from;



    }

    public function addNumberInPhonebook($mobile)
    {
        return false;
    }


    /**
     * @param $text
     * @param $mobiles
     * @return false|mixed
     */
    public function sendBulkSMS($text, $mobiles)
    {
      
        $postFields = [
            "messageText" => $text,
            "lineNumber"  =>  $this->from,
            "mobiles"     => $mobiles
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => self::API_URL . "send/bulk",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode($postFields)
            ,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'x-api-key:' . $this->api_key,
            ],
        ]);

        try {
            $response = json_decode(curl_exec($curl));
	        // self::saveLog($response);

            curl_close($curl);
            return $response;
        } catch (Exeption $e) {
            return false;
        }
    }

    /**
     * @param $parameters
     * @param $templateId
     * @param $mobile
     * @return false|mixed
     */
    public function sendVerifySMS($parameters, $templateId, $mobile)
    {



        

        foreach($parameters['params'] as &$param){
            $param->value = mb_substr($param->value,0,25);
        }

        $postFields = json_encode([
            "mobile"     => $mobile,
            "templateId" => $templateId,
            "parameters" => $parameters['params']
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => self::API_URL . "send/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $postFields,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'x-api-key:' . $this->api_key,
            ],
        ]);

        try {
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
            return $response;
        } catch (Exeption $e) {
            return false;
        }
    }

      /**
     * @return false|mixed
     */
    public function getCredit()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => self::API_URL . "credit",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'x-api-key:' . $this->api_key,
            ],
        ]);

        try {
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
            return $response;
        } catch (Exeption $e) {
            return false;
        }
    }

    /**
     * @return false|mixed
     */
    public function getLine()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => self::API_URL . "line",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'x-api-key:' . $this->api_key,
            ],
        ]);

        try {
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
            return $response;
        } catch (Exeption $e) {
            return false;
        }
    }

  

    /**
     * @return false|mixed
     */
    public function getSendReport()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => self::API_URL . "send/live",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'x-api-key:' . get_option('prk_sms_info_api_key'),
            ],
        ]);

        try {
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
            return $response;
        } catch (Exeption $e) {
            return false;
        }
    }

    /**
     * @return false|mixed
     */
    public static final function getReceiveReport()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => self::API_URL . "receive/live",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'x-api-key:' . get_option('prk_sms_info_api_key'),
            ],
        ]);

        try {
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
            return $response;
        } catch (Exeption $e) {
            return false;
        }
    }



    
}