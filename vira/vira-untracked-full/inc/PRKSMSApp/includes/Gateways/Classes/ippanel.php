<?php namespace PRKSMSApp\Gateways\Classes;

use PRKSMSApp\Gateways\Interfaces\SMSInterface;

use stdClass;

class Ippanel implements SMSInterface{

    const VerifySMS_API_URL = 'https://ippanel.com/';
    const API_URL = 'https://ippanel.com/services.jspd/';
    const API_URL_V1 = "http://api.ippanel.com/api/v1/";

    private static $instance;

    private $prk_getways_sms_options;

    private $username;

    private $password;

    private $from;

    private $api_key;

    private $phonebook_id;

    public static function get_instance($prk_getways_options) {
       
        if ( is_null( self::$instance ) ) {
            self::$instance = new self($prk_getways_options);
        }
		
		return self::$instance;
	}


    public function __construct($prk_getways_options)
    {
        $this->prk_getways_sms_options = $prk_getways_options;

        $this->username = $this->prk_getways_sms_options->username;

        $this->password = html_entity_decode($this->prk_getways_sms_options->password);

        $this->from = $this->prk_getways_sms_options->from;

        $this->api_key = $this->prk_getways_sms_options->api_key;

        $this->phonebook_id = $this->prk_getways_sms_options->phonebook_id;


    }

    public function sendBulkSMS($text, $mobiles){

        $responseData = new stdClass;

        $responseData->status = 0;

        $responseData->data = false;

		$param =[
            'uname'=>$this->username,
            'pass'=>$this->password,
            'from'=>$this->from,
            'message'=>$text,
            'to'=>json_encode($mobiles),
            'op'=>'send'
        ];
					
		$handler = curl_init(self::API_URL);             
		curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($handler, CURLOPT_POSTFIELDS, $param);                       
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($handler);
		$response = json_decode($response);
        
        if(is_array($response)){

            $responseData->status = 1;

            $responseData->data = $response[1];;
            
        }

                    
		return $responseData;
        
    }


    public function addNumberInPhonebook($mobile){

        $responseData = new stdClass;

        $responseData->status = 0;

        $responseData->data = false;


        $list[] = (object) [
            'number'       => $mobile,
            'name'         => "کاربر",
            'phonebook_id' => $this->phonebook_id
        ];

        $param = [
            'list' => $list,
        ];

        $url = self::API_URL_V1."phonebook/numbers-add-list";			
		$handler = curl_init($url);             
		curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($param));                       
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handler, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization:' . $this->api_key,
        ]); 
		$response = curl_exec($handler);

 
		$response = json_decode($response);
     
        if(is_array($response) && $response['status']== 'OK' && $response['code']==200 ){

            $responseData->status = 1;

            $responseData->data = $response['data'];;
            
        }

                    
		return $responseData;
        
    }

public function sendVerifySMS($parameters, $templateId, $to)
{
    $out = (object)['status'=>0,'data'=>false];
    if (empty($templateId) || empty($to)) return $out;

    // 1) ورودی‌ها
    $incoming = [];
    if (!empty($parameters['params']) && is_array($parameters['params'])) {
        $incoming = array_change_key_case(array_column($parameters['params'], 'value','name'), CASE_LOWER);
    }

    // 2) متن مخصوص همین رویداد (fallback به متن عمومی)
    $patternText = '';
    if (!empty($parameters['name'])) $patternText = (string)get_option($parameters['name'], '');
    if (!$patternText && !empty($this->prk_getways_sms_options->sms_text)) {
        $patternText = $this->prk_getways_sms_options->sms_text;
    }

    // 3) آماده‌سازی مقادیر
    $sanitize = function($v,$k){
        $v = (string)$v;
        if (in_array($k,['orderurl','carturl','rateurl'],true)) $v = preg_replace('#^https?://#i','', $v);
        $v = trim(preg_replace('/\s+/u',' ', $v));
        return (mb_strlen($v,'UTF-8')>200) ? mb_substr($v,0,200,'UTF-8') : $v;
    };

    // 4) ساخت پارامترها با همهٔ واریانت‌ها (Exact / lower / UPPER)
    $params = [];
    $addVariants = function(&$params, $ph, $val) {
        // ph همون placeholder داخل متن (case-sensitive)
        if ($ph !== '') $params[$ph] = $val;
        $low = strtolower($ph);
        $upp = strtoupper($ph);
        $params[$low] = $val;
        $params[$upp] = $val;
    };

    if ($patternText && preg_match_all('/#([a-zA-Z0-9_]+)#/', $patternText, $m)) {
        foreach ($m[1] as $ph) {
            $k = strtolower($ph);
            if (!array_key_exists($k,$incoming) || $incoming[$k]==='') continue;
            $val = $sanitize($incoming[$k], $k);
            $addVariants($params, $ph, $val);
        }
    }
    // اگر تو متن چیزی پیدا نشد، از همه ورودی‌ها واریانت بساز
    if (!$params) {
        foreach ($incoming as $k=>$v) {
            if ($v === '' || $v === null) continue;
            $val = $sanitize($v, $k);
            $addVariants($params, $k, $val);
        }
    }

    $recipient  = $this->toE164($to);
    $originator = $this->normalizeFrom($this->from);

    // ---- Try 1: transactional shared (بدون from_number) ----
    $payload = [
        'sending_type' => 'pattern',
        'code'         => $templateId,
        'recipients'   => [ $recipient ],
        'params'       => $params,
        'type'         => 'transactional',
    ];
    $res = $this->ippanel_edge_send($payload);
    if ($res && !empty($res['meta']['status'])) { $out->status=1; $out->data=$res['data']['message_outbox_ids']??true; return $out; }

    // ---- Try 2: transactional با from_number (برای غیر‌اشتراکی) ----
    $payload['from_number'] = $originator;
    $res = $this->ippanel_edge_send($payload);
    if ($res && !empty($res['meta']['status'])) { $out->status=1; $out->data=$res['data']['message_outbox_ids']??true; return $out; }

    // ---- Try 3: sms pattern (بدون type) ----
    unset($payload['type'], $payload['from_number']);
    $res = $this->ippanel_edge_send($payload);
    if ($res && !empty($res['meta']['status'])) { $out->status=1; $out->data=$res['data']['message_outbox_ids']??true; return $out; }

    // ---- Try 4: sms pattern با from_number ----
    $payload['from_number'] = $originator;
    $res = $this->ippanel_edge_send($payload);
    if ($res && !empty($res['meta']['status'])) { $out->status=1; $out->data=$res['data']['message_outbox_ids']??true; return $out; }

    // ---- Fallback Legacy (مثل کد رهگیری) ----
    // Legacy کلیدها را دقیقا مثل placeholder می‌خواهد
    $legacyParams = [];
    if ($patternText && preg_match_all('/#([a-zA-Z0-9_]+)#/', $patternText, $m2)) {
        foreach ($m2[1] as $ph) {
            $k = strtolower($ph);
            if (isset($incoming[$k]) && $incoming[$k] !== '') $legacyParams[$ph] = (string)$incoming[$k];
        }
    } else {
        foreach ($incoming as $k=>$v) if ($v!=='') $legacyParams[$k]=(string)$v;
    }

    $legacyUrl = self::VerifySMS_API_URL
        . "patterns/pattern?username=".$this->username
        . "&password=".urlencode($this->password)
        . "&from={$this->from}"
        . "&to=".json_encode($to)
        . "&input_data=".urlencode(json_encode($legacyParams, JSON_UNESCAPED_UNICODE))
        . "&pattern_code={$templateId}";

    $h = curl_init($legacyUrl);
    curl_setopt($h, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($h, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($h, CURLOPT_CUSTOMREQUEST, "POST");
    $legacyRaw = curl_exec($h);
    curl_close($h);

    if (intval($legacyRaw)) { $out->status=1; $out->data=true; return $out; }

    error_log('IPPANEL: all attempts failed for template '.$templateId);
    return $out;
}

// helper برای Edge
private function ippanel_edge_send(array $payload)
{
    $ch = curl_init('https://edge.ippanel.com/v1/api/send');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'Authorization: ' . $this->api_key,
        ],
        CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
    ]);
    $raw = curl_exec($ch);
    $err = curl_errno($ch) ? curl_error($ch) : '';
    curl_close($ch);
    if ($err) { error_log('IPPANEL CURL error: '.$err); return null; }
    $res = json_decode($raw, true);
    if (empty($res['meta']['status'])) error_log('IPPANEL EDGE failed: '.$raw);
    return $res;
}




    private function toE164($mobile) {
        $d = preg_replace('/\D+/', '', $mobile);
        if (strpos($d,'98')===0) return '+'.$d;
        if (strpos($d,'09')===0) return '+98'.substr($d,1);
        if (strpos($d,'9')===0 && strlen($d)===10) return '+98'.$d;
        if (strpos($mobile,'+98')===0) return $mobile;
        return $mobile; // fallback
    }
    private function normalizeFrom($from) {
        $d = preg_replace('/\D+/', '', $from);
        if (strpos($d,'98')===0) return '+'.$d;
        if (strpos($d,'0')===0)  return '+98'.substr($d,1);
        if (strpos($from,'+')===0) return $from;
        if (strpos($d,'3000')===0) return '+98'.$d; // شماره خدماتی کوتاه
        return $from;
    }



    public function getCredit(){
        $responseData = new stdClass;

        $responseData->status = 0;

        $responseData->data = false;

        $param = array
        (
            'uname'=>$this->username,
            'pass'=>$this->password,
            'op'=>'credit'
        );
        
        $handler = curl_init(self::API_URL);             
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $param);                       
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($handler);

        $response = json_decode($response);
        if(is_array($response)){

            $responseData->status = 1;

            $responseData->data = $response[1];
            
        }

                    
		return $responseData;

        
    }

    




  


}