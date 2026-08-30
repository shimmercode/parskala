<?php
namespace PRKSMSApp\Gateways\Classes;

use PRKSMSApp\Gateways\Interfaces\SMSInterface;
use stdClass;

class Mediana implements SMSInterface
{
	const BASE_URL = 'https://api.mediana.ir/sms/v1/';

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
		$this->api_key = $this->prk_getways_sms_options->api_key;
		$this->from    = trim($this->prk_getways_sms_options->from ?? '');
	}


    public function sendBulkSMS($text, $mobiles){
        $responseData = new stdClass();
        $responseData->status = 0;

        if (empty($text) || empty($mobiles)) return $responseData;

        $receptor = is_array($mobiles) ? implode(",", $mobiles) : $mobiles;

        $param = [
            "message"  => mb_substr($text, 0, 400), // محدودیت برای امن بودن
            "receptor" => $receptor,
        ];

        // اگر خط اختصاصی تعریف شده، از اون استفاده کن
        if (!empty($this->from)) {
            $param["sender"] = $this->from;
        } else {
            // در غیر این صورت از خطوط OTP اشتراکی استفاده کن
            $param["type"] = "informational";
        }

        $response = $this->call_api('send/simple', $param);

        if ($response && isset($response->meta->code) && $response->meta->code === 'OK') {
            $responseData->status = 1;
            $responseData->data = $response->data ?? [];
        } else {
            $responseData->message = $response->meta->errors[0]->errors[0] ?? 'خطا در ارسال';
        }

        return $responseData;
    }

	/**
	 * ارسال پیام بر اساس پترن با type: informational در صورت نداشتن شماره فرستنده
	 */
	public function sendVerifySMS($parameters, $templateId, $to)
	{
		$responseData = new \stdClass();
		$responseData->status = 0;

		if (empty($parameters['params']) || empty($templateId) || empty($to)) {
			$responseData->message = 'پارامترهای ناقص';
			return $responseData;
		}

		// 📌 متن پیام از تنظیمات (همون #firstname# و ... که باهاش پترن ساختی)
		$sms_text = get_option("{$parameters['name']}");

		// 🧠 تبدیل لیست ورودی به آرایه name => value برای راحتی جایگزینی
		$params_assoc = array_column($parameters['params'], 'value', 'name');

		// 🔍 استخراج توکن‌ها بر اساس ترتیب هشتک‌های داخل متن
		preg_match_all('/#(.*?)#/', $sms_text, $matches);
		// 🔍 استخراج توکن‌ها بر اساس ترتیب هشتک‌های داخل متن
		preg_match_all('/#(.*?)#/', $sms_text, $matches);

		$tokens = [];
		$used   = [];
		$i      = 1;

		foreach ($matches[1] as $key) {
			$key = strtolower(trim($key));

			// جلوگیری از تکرار
			if (in_array($key, $used)) continue;
			$used[] = $key;

			// 📌 استثنا برای مدیانا: اگر متن شامل carturl یا url بود، بفرستیم داخل 'url'
			if (in_array($key, ['carturl','orderurl','rateurl', 'url']) && isset($params_assoc[$key])) {
				// اگه قبلاً url نداشتیم، بذاریمش جدا
				if (!isset($tokens['url'])) {
					$tokens['url'] = $params_assoc[$key];
				}
				continue; // دیگه داخل token1..10 قرار نگیره
			}

			// 📦 توکن‌های معمولی
			if (isset($params_assoc[$key])) {
				if ($i <= 10) {
					$tokens["token$i"] = mb_substr($params_assoc[$key], 0, 50);
					$i++;
				} elseif ($i === 11) {
					$tokens["token20"] = mb_substr($params_assoc[$key], 0, 50);
					break;
				}
			}
		}

		$payload = [
			"recipients"  => [$to],
			"patternCode" => $templateId,
			"parameters"  => $tokens
		];

		if (empty($this->from)) {
			$payload["type"] = "informational";
		} else {
			$payload["sendingNumber"] = $this->from;
		}

		$response = $this->call_api('send/pattern', $payload);

		if ($response && isset($response->meta->code) && $response->meta->code === 'OK') {
			$responseData->status = 1;
			$responseData->data = $response->data ?? [];
		} else {
			$responseData->message = $response->meta->errors[0]->errors[0] ?? 'خطا در ارسال پیامک';
		}

		return $responseData;
	}



	public function getCredit()
	{
		$responseData = new stdClass();
		$responseData->status = 0;

		$response = $this->call_api('credit', []);

		if ($response && isset($response->meta->code) && $response->meta->code === 'OK') {
			$responseData->status = 1;
			$responseData->data = $response->data ?? [];
		}

		return $responseData;
	}

	private function call_api($endpoint, $params = [])
	{
		$url = self::BASE_URL . ltrim($endpoint, '/');

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
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