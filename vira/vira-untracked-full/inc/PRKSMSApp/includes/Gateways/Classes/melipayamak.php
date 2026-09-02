<?php namespace PRKSMSApp\Gateways\Classes;

use PRKSMSApp\Gateways\Interfaces\SMSInterface;
use stdClass;

class Melipayamak implements SMSInterface{

    const API_URL = 'https://rest.payamak-panel.com/api/';
    const API_URL_wsdl = 'http://api.payamak-panel.com/post/';

    protected $client;



    private static $instance;


    private $prk_getways_sms_options;

    private $username;

    private $password;

    private $from;

    private $phonebook_id;

    private $api_key;
    

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

        $this->api_key = isset($this->prk_getways_sms_options->api_key)
            ? trim((string) $this->prk_getways_sms_options->api_key)
            : '';


        $this->from = $this->prk_getways_sms_options->from;

        $this->phonebook_id = $this->prk_getways_sms_options->phonebook_id;

    }

    private function CheckMobileExistInContact($mobile){
        $param = [
            'username' => $this->username,
            'password' => $this->password,
            'GroupIds' => $this->phonebook_id,
            'mobilenumber'=>$mobile,

        ];

        $response = $this->execute_wsdl(self::API_URL_wsdl.'Contacts.asmx/CheckMobileExistInContact',$param);


        if( $response->status == 1 ){

            if(isset($response->data->{0}) && $response->data->{0} == '1'){

                return true;

            }

        }

        return false;

    }

    public function addNumberInPhonebook($mobile){


        if($this->CheckMobileExistInContact($mobile)){
            return;
        }

        $param = [
            'username' => $this->username,
            'password' => $this->password,
            'GroupIds' => $this->phonebook_id,
            'mobilenumber'=>$mobile,
            'firstname'=>'کاربر',
            'lastname'=>'سایت',
            'nickname'=>'',
            'corporation'=>'',
            'phone'=>'',
            'fax'=>'',
            'birthdate'=>'2023-02-09',
            'email'=>'',
            'gender'=>2,
            'province'=>8,
            'city'=>347,
            'address'=>'',
            'postalCode'=>'',
            'additionaldate'=>'2023-02-09',
            'additionaltext'=>'',
            'descriptions'=>''
        ];
      
		$response = $this->execute_wsdl(self::API_URL_wsdl.'Contacts.asmx/AddContact',$param);

        if( $response->status == 1 ){

            if(isset($response->data->{0}) && $response->data->{0} == '1'){

                return $this->responseDate(1,$response->data);

            }

        }



    }


    public function responseDate($status,$data){
        $responseData = new stdClass;

        $responseData->data = false;

        $responseData->status = 0;

        if($status == 1){

            $responseData->status = 1;

            $responseData->data = $data;
    
        }

        return $responseData;

    }


    private function getAuthPassword()
    {
        return !empty($this->api_key) ? $this->api_key : $this->password;
    }

    private function extractIncomingParams($parameters)
    {
        $incoming = array();

        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (!is_array($parameters)) {
            return $incoming;
        }

        if (!empty($parameters['params']) && is_array($parameters['params'])) {
            foreach ($parameters['params'] as $param) {
                if (is_object($param)) {
                    $param = get_object_vars($param);
                }

                if (!is_array($param)) {
                    continue;
                }

                if (isset($param['name'])) {
                    $name  = strtolower(trim((string) $param['name']));
                    $value = isset($param['value']) ? trim((string) $param['value']) : '';

                    if ($name !== '') {
                        $incoming[$name] = $value;
                    }
                }
            }
        }

        foreach ($parameters as $key => $value) {
            if ($key === 'params' || !is_scalar($value)) {
                continue;
            }

            $name = strtolower(trim((string) $key));

            if ($name !== '') {
                $incoming[$name] = trim((string) $value);
            }
        }

        if (isset($incoming['code']) && !isset($incoming['token'])) {
            $incoming['token'] = $incoming['code'];
        }

        if (isset($incoming['token']) && !isset($incoming['code'])) {
            $incoming['code'] = $incoming['token'];
        }

        return $incoming;
    }

    private function extractOtpCode($parameters)
    {
        $incoming = $this->extractIncomingParams($parameters);

        foreach (array('code', 'token', 'otp') as $key) {
            if (!empty($incoming[$key])) {
                return trim((string) $incoming[$key]);
            }
        }

        return '';
    }

    private function getMelipayamakErrorMessage($value)
    {
        $value = (string) $value;

        $errors = array(
            '-111' => 'IP درخواست‌کننده نامعتبر است',
            '-110' => 'الزام استفاده از API Key به جای رمز عبور',
            '-109' => 'الزام تنظیم IP مجاز برای استفاده از API',
            '-108' => 'IP به دلیل تلاش ناموفق استفاده از API مسدود شده است',
            '0'    => 'نام کاربری یا رمز عبور/API Key اشتباه است',
            '2'    => 'اعتبار کافی نیست',
            '3'    => 'محدودیت در ارسال روزانه',
            '4'    => 'محدودیت در حجم ارسال',
            '5'    => 'شماره فرستنده معتبر نیست',
            '6'    => 'سامانه در حال بروزرسانی است یا لینک ارسال اپراتور قطع است',
            '7'    => 'متن حاوی کلمه فیلتر شده است',
            '9'    => 'ارسال از خطوط عمومی از طریق وب‌سرویس امکان‌پذیر نیست',
            '10'   => 'کاربر فعال نیست',
            '11'   => 'ارسال نشده',
            '12'   => 'مدارک کاربر کامل نیست',
            '14'   => 'متن حاوی لینک است',
            '15'   => 'عدم وجود لغو 11 در انتهای متن پیامک',
            '16'   => 'شماره گیرنده‌ای یافت نشد',
            '17'   => 'متن پیامک خالی است',
            '18'   => 'شماره موبایل معتبر نیست',
        );

        return isset($errors[$value]) ? $errors[$value] : 'خطای نامشخص ملی پیامک: ' . $value;
    }

    public function sendBulkSMS($text, $mobiles)
    {
        $param = [
            'username' => $this->username,
            'password' => $this->getAuthPassword(),
            'from'     => $this->from,
            'to'       => join(";", $mobiles),
            'text'     => $text
        ];

        return $this->execute(self::API_URL . 'SendSMS/SendSMS', $param);
    }

    public function sendVerifySMS($parameters, $templateId, $mobile)
    {
        $code = $this->extractOtpCode($parameters);

        if (!empty($code) && !empty($mobile)) {

            $param = [
                'username' => $this->username,
                'password' => $this->getAuthPassword(),
                'From'     => $this->from,
                'to'       => $mobile,
                'code'     => $code,
            ];

            $response = $this->execute(self::API_URL . 'SendSMS/SendOtp', $param);

            if (is_object($response) && !empty($response->status)) {
                return $response;
            }

            error_log('MELIPAYAMAK SendOtp failed: ' . json_encode(array(
                'param'    => $param,
                'response' => $response,
            ), JSON_UNESCAPED_UNICODE));
        }

        /*
        * Fallback مسیر قبلی:
        * اگر کد OTP از پارامترهای قالب استخراج نشد یا کاربر هنوز از پترن قبلی استفاده می‌کرد،
        * ساختار قدیمی BaseServiceNumber حفظ می‌شود.
        */
        $parameters = $this->extractIncomingParams($parameters);

        $text = [];

        if (empty($parameters) || empty($templateId) || empty($mobile)) {
            error_log("MELIPAYAMAK sms parameter check failed");
            return $this->responseDate(0, false);
        }

        preg_match_all("/#([a-zA-Z0-9_]+)#/", $this->prk_getways_sms_options->sms_text, $matches_variables);

        foreach ($matches_variables[1] as $variable) {
            $key = strtolower($variable);

            if (isset($parameters[$key])) {
                $text[] = $parameters[$key];
            }
        }

        $param = [
            'username' => $this->username,
            'password' => $this->getAuthPassword(),
            'to'       => $mobile,
            'bodyId'   => $templateId,
            'text'     => join(";", $text)
        ];

        return $this->execute(self::API_URL . 'SendSMS/BaseServiceNumber', $param);
    }




    public function getCredit(){



        $param=[
            'username' => $this->username,
            'password' => $this->getAuthPassword()
        ];

        $response = $this->execute(self::API_URL.'SendSMS/GetCredit',$param);

        if(is_object($response) && $response->status = 1){

            $response->data = number_format($response->data, 1);;
            
        }

        return  $response;
        
    }





    protected function execute($url, $data = null)
    {
        $fields_string = "";

        $responseData = new stdClass;

        $responseData->data = false;
        $responseData->status = 0;
        $responseData->message = '';

        if (!is_null($data)) {
            $fields_string = http_build_query($data);
        }

        $handle = curl_init();

        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);

        $raw_response = curl_exec($handle);
        $response     = json_decode($raw_response);

        $code         = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $curl_errno   = curl_errno($handle);
        $curl_error   = curl_error($handle);

        curl_close($handle);

        if ($curl_errno) {
            $responseData->message = $curl_error;
            $responseData->data = $raw_response;
            error_log('MELIPAYAMAK CURL ERROR: ' . $curl_error);
            return $responseData;
        }

        if (is_object($response) && isset($response->RetStatus) && intval($response->RetStatus) === 1) {
            $responseData->status = 1;
            $responseData->data = isset($response->Value) ? $response->Value : true;
            $responseData->message = isset($response->StrRetStatus) ? $response->StrRetStatus : 'OK';

            return $responseData;
        }

        if (is_object($response) && isset($response->Value)) {
            $responseData->data = $response->Value;
            $responseData->message = $this->getMelipayamakErrorMessage($response->Value);
        } else {
            $responseData->data = $raw_response;
            $responseData->message = 'پاسخ معتبر از ملی پیامک دریافت نشد';
        }

        error_log('MELIPAYAMAK API FAILED: ' . json_encode(array(
            'url'      => $url,
            'request'  => $data,
            'response' => $response,
            'raw'      => $raw_response,
            'http'     => $code,
            'message'  => $responseData->message,
        ), JSON_UNESCAPED_UNICODE));

        return $responseData;
    }






    protected function execute_wsdl($url, $data = null)
	{
		
		$fields_string = "";

        $responseData = new stdClass;

        $responseData->data = false;

        $responseData->status = 0;
		
		if (!is_null($data)) {
			
			$fields_string = http_build_query($data);
			
		}
		
		$handle = curl_init();
		
		curl_setopt($handle, CURLOPT_URL, $url);
		
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($handle, CURLOPT_POST, true);
		
		curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);
		
		
		$response     = curl_exec($handle);
		
		$code         = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		
		$curl_errno   = curl_errno($handle);
		
		$curl_error   = curl_error($handle);

		if ($curl_errno) {
			
			throw new \Exception($curl_error);
			
		}
		
		curl_close($handle);

        $xml = simplexml_load_string($response);

        $json = json_encode($xml);

        $json_decode = json_decode($json);

        if(is_object($json_decode)){

            $responseData->status = 1;

            $responseData->data = $json_decode;

        }

		return $responseData;
		
		
	}

}