<?php

namespace PRKSMSApp\Gateways\Classes;

use PRKSMSApp\Gateways\Interfaces\SMSInterface;
use stdClass;

class msgway implements SMSInterface
{
	const BASE_URL = 'https://api.msgway.com/';

	private static $instance;
	private $prk_getways_sms_options;
	private $api_key;
	private $from;

	public static function get_instance($prk_getways_options)
	{
		if (is_null(self::$instance)) {
			self::$instance = new self($prk_getways_options);
		}
		return self::$instance;
	}

	public function __construct($prk_getways_options)
	{
		$this->prk_getways_sms_options = $prk_getways_options;
		$this->api_key = trim($this->prk_getways_sms_options->api_key ?? '');
		$this->from    = trim($this->prk_getways_sms_options->from ?? '');
	}

	public function sendBulkSMS($text, $mobiles)
	{
		$responseData = new stdClass();
		$responseData->status = 0;

		if (empty($text) || empty($mobiles)) return $responseData;

		$mobile = is_array($mobiles) ? reset($mobiles) : $mobiles; // فقط یک گیرنده مجاز است

		$payload = [
			"mobile"      => $this->normalize_mobile($mobile),
			"method"      => "sms",
			"templateID"  => 0, // ارسال متن ساده بدون پترن (پترن ۰ نیست ولی msgway نیاز به یک templateID داره)
			"params"      => [ mb_substr($text, 0, 400) ]
		];

		$response = $this->call_api('send', $payload);

		if ($response && $response->status === 'success') {
			$responseData->status = 1;
			$responseData->data = $response ?? [];
		} else {
			$responseData->message = $response->error->message ?? 'خطا در ارسال';
		}

		return $responseData;
	}

public function sendVerifySMS($parameters, $templateId, $to)
{
	$responseData = new \stdClass();
	$responseData->status = 0;

	if (empty($parameters['params']) || empty($templateId) || empty($to)) {
		$responseData->message = 'پارامترهای ناقص';
		return $responseData;
	}

	// 👇 از متن پیام ذخیره‌شده در تنظیمات استفاده کن
	$sms_text = get_option("{$parameters['name']}");

	// پارامترها به صورت name => value تبدیل بشن
	$params_assoc = array_column($parameters['params'], 'value', 'name');

	// استخراج توکن‌ها به ترتیب ظاهر شدن در متن
	preg_match_all('/#(.*?)#/', $sms_text, $matches);

	$tokens = [];
	$used = [];
	foreach ($matches[1] as $token_key) {
		$key = strtolower(trim($token_key));

		if (in_array($key, $used)) continue;
		$used[] = $key;

		if (isset($params_assoc[$key])) {
			$tokens[] = mb_substr($params_assoc[$key], 0, 40);
		}
		// پر نشدن هم اشکال نداره. بهتره ارسال نشه تا اینکه اشتباه بره
		if (count($tokens) >= 10) break;
	}

	$payload = [
		"mobile"     => $this->normalize_mobile($to),
		"method"     => "sms",
		"templateID" => intval($templateId),
		"params"     => $tokens
	];

	$response = $this->call_api('send', $payload);

	if ($response && $response->status === 'success') {
		$responseData->status = 1;
		$responseData->data = $response ?? [];
	} else {
		$responseData->message = $response->error->message ?? 'خطا در ارسال پیامک';
	}

	return $responseData;
}


	public function getCredit()
	{
		// msgway در مستندات اطلاعاتی از اعتبار حساب نداده است
		$responseData = new stdClass();
		$responseData->status = 0;
		$responseData->message = 'امکان دریافت موجودی وجود ندارد';
		return $responseData;
	}

	private function normalize_mobile($mobile)
	{
		return (strpos($mobile, '+98') === 0) ? $mobile : '+98' . ltrim($mobile, '0');
	}

	private function call_api($endpoint, $params = [])
	{
		$url = self::BASE_URL . ltrim($endpoint, '/');
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'apiKey: ' . $this->api_key,
			'Content-Type: application/json',
		]);
		$response = curl_exec($ch);
		curl_close($ch);
		return json_decode($response);
	}
}
