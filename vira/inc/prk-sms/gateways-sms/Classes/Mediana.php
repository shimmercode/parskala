<?php namespace PRKSMS\Gateways\Classes;

use PRKSMS\Gateways\Interfaces\SMSInterface;

class Mediana implements SMSInterface {

	const API_URL = "https://api.mediana.ir/";

	private $prk_getways_sms_options;
	private $api_key;

	public function __construct($prk_getways_options) {
		$this->prk_getways_sms_options = $prk_getways_options;
		$this->api_key = $this->prk_getways_sms_options->api_key;
	}

	/**
	 * ارسال پیامک OTP با استفاده از پترن OTP
	 *
	 * $data = [
	 *   'to' => '0912xxxxxxx',
	 *   'pattern' => [
	 *      'id' => 'کد پترن',
	 *      'params' => [
	 *         ['name' => 'otpCode', 'value' => '1234']
	 *      ]
	 *   ]
	 * ]
	 */
	public function sendPattern($data) {
		$to         = $data['to'];
		$pattern    = $data['pattern'];
		$patternCode = $pattern['id'];

		// پیدا کردن مقدار OTP (فقط token1 در OTP مجازه)
		$otpCode = '';
		foreach ($pattern['params'] as $param) {
			if ($param['name'] === 'otpCode') {
				$otpCode = mb_substr($param['value'], 0, 50); // محدودیت امن
				break;
			}
		}

		if (empty($otpCode)) {
			return ['success' => false, 'message' => 'کد تأیید (otpCode) وارد نشده است.'];
		}

		$payload = [
			'patternCode' => $patternCode,
			'recipient'   => $to,
			'otpCode'     => $otpCode
		];

		$response = $this->call_api('sms/v1/send/otp', $payload);

		if ($response && isset($response->meta->code) && $response->meta->code === 'OK') {
			return ['success' => true];
		}

		return ['success' => false, 'message' => $response->meta->errors[0]->errors[0] ?? 'خطا در ارسال پیامک'];
	}

	/**
	 * اجرای درخواست CURL به API مدیانا
	 */
	private function call_api($endpoint, $payload) {
		$url = self::API_URL . $endpoint;

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Authorization: Bearer ' . $this->api_key,
			'Accept: application/json',
			'Content-Type: application/json'
		]);

		$response = curl_exec($ch);
		curl_close($ch);

		return json_decode($response);
	}
}
