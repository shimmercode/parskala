<?php namespace PRKSMSApp\Gateways\Classes;

use PRKSMSApp\Gateways\Interfaces\SMSInterface;
use stdClass;

class Kavenegar implements SMSInterface {

    const API_URL = "https://api.kavenegar.com/v1/%s/%s/%s.json/";

    private static $instance;


    private $prk_getways_sms_options;
    
    private $api_key;

    private $from;

    private $token   = null;

    private $token2  = null;

    private $token3  = null;

    private $token20 = null;

    private $phonebook_id;

    const ACCEPET_TOKENS = [
        1=>"token", //without space required in text pattern
        2=>"token2", //without space
        3=>"token3", //without space 
    ];

    const VARIABLES_HAVE_SPACES = [
        'description',
        'items',
        'company',
        'address1',
        'address2',
        'name',
        'productname',
        'clientname',
        'paymentmethod',
        'shipping',
        'state',
        'city',

    ];

    const MAX_TOKENS_IN_TEXT = 3;


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

        $this->phonebook_id = $this->prk_getways_sms_options->phonebook_id;



    }

    protected function get_path($method, $base = 'sms')
    {
        return sprintf(self::API_URL, $this->api_key, $base, $method);
    }

    public function sendBulkSMS($text, $mobiles)
    {

        if (is_array($mobiles)) {
            $receptor = implode(",", $mobiles);
        }

		$param =[
            "receptor" => $receptor,
            "sender" => $this->from,
            "message" => $text,
           
        ];
        
        $path   = $this->get_path("send");

        return $this->execute($path, $param);
        
        
    }


    public function sendVerifySMS($parameters, $templateId, $mobile)
    {
        $responseData = new \stdClass();
        $responseData->status = 0;

        // ورودی‌ها
        $assoc = array_change_key_case(array_column($parameters['params'], 'value','name'), CASE_LOWER);
        if (empty($assoc) || empty($templateId) || empty($mobile)) {
            error_log("sms parameter check");
            return $responseData;
        }

        // متن «همان الگو» برای تعیین ترتیب متغیرها
        $patternText = '';
        if (!empty($parameters['name'])) {
            $patternText = get_option($parameters['name'], '');
        }
        if (!$patternText) {
            $patternText = $this->prk_getways_sms_options->sms_text ?? '';
        }

        // محدودیت‌ها
        $MAX20_TOTAL = 37; // سقف کل token20

        // کمک‌تابع‌ها
        $mb_trunc = function ($txt, $max) {
            $txt = (string)$txt;
            if ($max <= 0) return '';
            if (mb_strlen($txt,'UTF-8') <= $max) return $txt;
            return mb_substr($txt, 0, max(1,$max-1), 'UTF-8').'…';
        };
        $no_space = function ($txt) use ($mb_trunc) {
            // کاوه‌نگار: توکن‌های فشرده بدون فاصله
            $t = preg_replace('/\s+/u', '', (string)$txt);
            return $mb_trunc($t, 50); // سقف امن برای token/token2/token3
        };

        // استخراج ترتیب متغیرها از متن الگو
        $ordered = [];
        if ($patternText && preg_match_all('/#([a-zA-Z0-9_]+)#/', $patternText, $m)) {
            $ordered = $m[1];
        } else {
            // اگر چیزی پیدا نشد، کلیدهای ورودی را به همان ترتیب استفاده کن
            $ordered = array_keys($assoc);
        }

        // پاک‌سازی توکن‌های قبلی
        $this->token = $this->token2 = $this->token3 = $this->token20 = null;
        $tCount = 1;       // برای token..token3
        $t20Used = false;  // آیا token20 پر شده؟

        foreach ($ordered as $var) {
            $k = strtolower($var);
            if (!isset($assoc[$k])) continue;
            $val = $assoc[$k];

            // اگر متغیر از نوع دارای فاصله است -> بفرست داخل token20 (با سقف 37)
            if (in_array($k, self::VARIABLES_HAVE_SPACES, true) && !$t20Used) {
                
                $flat = preg_replace('/\s+/u', ' ', (string)$val);
                $this->token20 = $mb_trunc($flat, $MAX20_TOTAL);
                $t20Used = true;
                continue;
            }

            // در غیر این صورت، تا 3 توکن فشرده را پر کن
            if ($tCount >= 1 && $tCount <= self::MAX_TOKENS_IN_TEXT) {
                $prop = self::ACCEPET_TOKENS[$tCount]; // token / token2 / token3
                $this->{$prop} = $no_space($val);
                $tCount++;
                continue;
            }

            // اگر چهارمین متغیر رسید و token20 هنوز خالی بود، آن را در token20 جا بده
            if (!$t20Used) {
                $flat = preg_replace('/\s+/u', ' ', (string)$val);
                $this->token20 = $mb_trunc($flat, $MAX20_TOTAL);
                $t20Used = true;
            }
            // اگر باز هم متغیرهای بیشتری بود، چاره‌ای نیست: پترن کاوه‌نگار ظرفیت نمایش ندارد
        }

        // ساخت payload فقط با فیلدهای موجود
        $param = [
            "receptor" => $mobile,
            "template" => $templateId,
            "type"     => "sms",
        ];
        if (!empty($this->token))   $param["token"]   = $this->token;
        if (!empty($this->token2))  $param["token2"]  = $this->token2;
        if (!empty($this->token3))  $param["token3"]  = $this->token3;
        if (!empty($this->token20)) $param["token20"] = $this->token20;

        $path = $this->get_path("lookup", "verify");
        return $this->execute($path, $param);
    }


    public function addNumberInPhonebook($mobile){

        $param =[
            "title"=>"کاربر",
            "number" => $mobile,
            "groupid" => $this->phonebook_id,

        ];

        $path   = $this->get_path("add", "group");

        return $this->execute($path, $param);
    }
  


    protected function execute($url, $data = null)
    {        

        $responseData = new stdClass;

        $responseData->status = 0;

        $responseData->data = false;

        $headers       = array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'charset: utf-8'
        );
        $fields_string = "";
        if (!is_null($data)) {
            $fields_string = http_build_query($data);
        }
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);
        
        $response     = curl_exec($handle);
        $code         = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $content_type = curl_getinfo($handle, CURLINFO_CONTENT_TYPE);
        $curl_errno   = curl_errno($handle);
        $curl_error   = curl_error($handle);
        $json_response = json_decode($response);

        if ($curl_errno) {
			throw new \Exception($curl_error);
		}

        if ($code == 200 && !is_null($json_response)){

            $json_return = $json_response->return;

            if ($json_return->status == 200) {

                $responseData->status = 1;

                $responseData->data = $json_response->entries;
            }            
          
        }

        return $responseData;
  
        
    }

    public function getCredit()
    {
        
    }


}