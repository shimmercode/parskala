<?php namespace PRKSMSApp\Gateways\Classes;

use PRKSMSApp\Gateways\Interfaces\SMSInterface;
use stdClass;

class Iranpayamak implements SMSInterface
{
    const BASE_URL = 'https://api.iranpayamak.com/ws/v1/';

    private static $instance = null;

    private $prk_getways_sms_options;

    private $from;

    private $api_key;

    private $phonebook_id;

    private $number_format = 'english';

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

        $this->from         = trim((string) ($this->prk_getways_sms_options->from ?? ''));
        $this->api_key      = trim((string) ($this->prk_getways_sms_options->api_key ?? ''));
        $this->phonebook_id = trim((string) ($this->prk_getways_sms_options->phonebook_id ?? ''));

        if ($this->from === '') {
            $this->from = '3000505';
        }
    }

    public function sendBulkSMS($text, $mobiles)
    {
        $responseData = $this->responseData();

        if (empty($this->api_key)) {
            $responseData->message = 'API Key سامانه ایران پیامک خالی است';
            return $responseData;
        }

        if (empty($text) || empty($mobiles)) {
            $responseData->message = 'متن پیامک یا شماره گیرنده خالی است';
            return $responseData;
        }

        $recipients = is_array($mobiles) ? array_values($mobiles) : array($mobiles);
        $recipients = array_values(array_filter(array_map(array($this, 'normalizeMobile'), $recipients)));

        if (empty($recipients)) {
            $responseData->message = 'شماره گیرنده معتبر نیست';
            return $responseData;
        }

        $payload = array(
            'text'          => (string) $text,
            'line_number'   => $this->normalizeLineNumber($this->from),
            'recipients'    => $recipients,
            'number_format' => $this->number_format,
            'schedule'      => null,
        );

        $response = $this->request('sms/simple', $payload);

        if ($this->isSuccess($response)) {
            $responseData->status = 1;
            $responseData->data   = isset($response->data) ? $response->data : $response;
            return $responseData;
        }

        $responseData->message = $this->extractMessage($response, 'خطا در ارسال پیامک ساده ایران پیامک');
        $responseData->data    = $response;

        error_log('IRANPAYAMAK SIMPLE FAILED: ' . $this->toJson(array(
            'payload'  => $payload,
            'response' => $response,
        )));

        return $responseData;
    }

    public function sendVerifySMS($parameters, $templateId, $to)
    {
        $responseData = $this->responseData();

        if (empty($this->api_key)) {
            $responseData->message = 'API Key سامانه ایران پیامک خالی است';
            return $responseData;
        }

        if (empty($templateId) || empty($to)) {
            $responseData->message = 'کد الگو یا شماره موبایل خالی است';
            return $responseData;
        }

        $incoming = $this->extractIncomingParams($parameters);
        $patternText = $this->getPatternText($parameters);
        $attributes = $this->buildPatternAttributes($patternText, $incoming);

        if (empty($attributes)) {
            $responseData->message = 'پارامترهای الگو قابل استخراج نیست';
            $responseData->data = array(
                'parameters'   => $parameters,
                'incoming'     => $incoming,
                'pattern_text' => $patternText,
            );

            error_log('IRANPAYAMAK EMPTY ATTRIBUTES: ' . $this->toJson($responseData->data));
            return $responseData;
        }

        $payload = array(
            'code'          => (string) $templateId,
            'attributes'    => $attributes,
            'recipient'     => $this->normalizeMobile($to),
            'line_number'   => $this->normalizeLineNumber($this->from),
            'number_format' => $this->number_format,
            'schedule'      => null,
        );

        if (function_exists('apply_filters')) {
            $payload = apply_filters('prk_iranpayamak_pattern_payload', $payload, $parameters, $templateId, $to, $incoming);
        }

        $response = $this->request('sms/pattern', $payload);

        if ($this->isSuccess($response)) {
            $responseData->status = 1;
            $responseData->data   = isset($response->data) ? $response->data : $response;
            return $responseData;
        }

        $responseData->message = $this->extractMessage($response, 'خطا در ارسال پیامک پترن ایران پیامک');
        $responseData->data    = $response;

        error_log('IRANPAYAMAK PATTERN FAILED: ' . $this->toJson(array(
            'payload'  => $payload,
            'response' => $response,
        )));

        return $responseData;
    }

    public function addNumberInPhonebook($mobile)
    {
        $responseData = $this->responseData();

        if (empty($this->api_key)) {
            $responseData->message = 'API Key سامانه ایران پیامک خالی است';
            return $responseData;
        }

        if (empty($this->phonebook_id) || empty($mobile)) {
            $responseData->message = 'کد دفترچه تلفن یا شماره موبایل خالی است';
            return $responseData;
        }

        $payload = array(
            'phone_book_id' => (int) $this->phonebook_id,
            'prefix'        => 'user',
            'name'          => 'کاربر',
            'mobile'        => $this->normalizeMobile($mobile),
            'attributes'    => array(),
        );

        if (function_exists('apply_filters')) {
            $payload = apply_filters('prk_iranpayamak_phonebook_payload', $payload, $mobile, $this->phonebook_id);
        }

        $response = $this->request('phone_book_data', $payload);

        if ($this->isSuccess($response)) {
            $responseData->status = 1;
            $responseData->data   = isset($response->data) ? $response->data : $response;
            return $responseData;
        }

        $responseData->message = $this->extractMessage($response, 'خطا در ذخیره شماره در دفترچه تلفن ایران پیامک');
        $responseData->data    = $response;

        error_log('IRANPAYAMAK PHONEBOOK FAILED: ' . $this->toJson(array(
            'payload'  => $payload,
            'response' => $response,
        )));

        return $responseData;
    }

    public function getCredit()
    {
        $responseData = $this->responseData();

        if (empty($this->api_key)) {
            $responseData->message = 'API Key سامانه ایران پیامک خالی است';
            return $responseData;
        }

        $response = $this->request('account/balance', null, 'GET');

        if ($this->isSuccess($response)) {
            $responseData->status = 1;
            $responseData->data   = isset($response->data) ? $response->data : $response;
            return $responseData;
        }

        $responseData->message = $this->extractMessage($response, 'خطا در دریافت اعتبار ایران پیامک');
        $responseData->data    = $response;

        return $responseData;
    }

    private function request($endpoint, $payload = null, $method = 'POST')
    {
        $endpoint = ltrim((string) $endpoint, '/');
        $url = self::BASE_URL . $endpoint;

        $authVariants = $this->getAuthHeaderVariants();
        $lastResponse = null;

        foreach ($authVariants as $authHeader) {
            $response = $this->rawRequest($url, $payload, $method, $authHeader);
            $lastResponse = $response;

            $httpCode = isset($response->http_code) ? (int) $response->http_code : 0;

            if (!in_array($httpCode, array(401, 403), true)) {
                return $response;
            }
        }

        return $lastResponse;
    }

    private function rawRequest($url, $payload = null, $method = 'POST', $authHeader = '')
    {
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        if (!empty($authHeader)) {
            $headers[] = $authHeader;
        }

        $ch = curl_init($url);

        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST  => strtoupper($method),
            CURLOPT_HTTPHEADER     => $headers,
        );

        if (!is_null($payload) && strtoupper($method) !== 'GET') {
            $options[CURLOPT_POSTFIELDS] = $this->toJson($payload);
        }

        curl_setopt_array($ch, $options);

        $raw = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($errno) {
            return (object) array(
                'status'    => 'error',
                'http_code' => $httpCode,
                'messages'  => $error,
                'raw'       => $raw,
            );
        }

        $decoded = json_decode((string) $raw);

        if (!is_object($decoded)) {
            return (object) array(
                'status'    => 'error',
                'http_code' => $httpCode,
                'messages'  => 'پاسخ JSON معتبر نیست',
                'raw'       => $raw,
            );
        }

        $decoded->http_code = $httpCode;

        return $decoded;
    }

    private function getAuthHeaderVariants()
    {
        $apiKey = trim((string) $this->api_key);

        if ($apiKey === '') {
            return array('');
        }

        if (stripos($apiKey, 'Bearer ') === 0) {
            $pure = trim(substr($apiKey, 7));

            return array(
                'Authorization: ' . $apiKey,
                'Authorization: ' . $pure,
                'X-API-KEY: ' . $pure,
                'Api-Key: ' . $pure,
            );
        }

        return array(
            'Authorization: Bearer ' . $apiKey,
            'Authorization: ' . $apiKey,
            'X-API-KEY: ' . $apiKey,
            'Api-Key: ' . $apiKey,
        );
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

        if (!empty($parameters['params'])) {
            $params = $parameters['params'];

            if (is_object($params)) {
                $params = get_object_vars($params);
            }

            if (is_array($params)) {
                foreach ($params as $key => $param) {
                    if (is_object($param)) {
                        $param = get_object_vars($param);
                    }

                    if (is_array($param)) {
                        if (isset($param['name'])) {
                            $name = strtolower(trim((string) $param['name']));
                            $value = isset($param['value']) ? (string) $param['value'] : '';

                            if ($name !== '') {
                                $incoming[$name] = $value;
                            }

                            continue;
                        }

                        foreach ($param as $innerKey => $innerValue) {
                            if (is_scalar($innerValue)) {
                                $name = strtolower(trim((string) $innerKey));
                                if ($name !== '') {
                                    $incoming[$name] = (string) $innerValue;
                                }
                            }
                        }

                        continue;
                    }

                    if (is_scalar($param)) {
                        $name = strtolower(trim((string) $key));
                        if ($name !== '') {
                            $incoming[$name] = (string) $param;
                        }
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
                $incoming[$name] = (string) $value;
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

    private function getPatternText($parameters)
    {
        $patternText = '';

        if (is_object($parameters)) {
            $parameters = get_object_vars($parameters);
        }

        if (is_array($parameters) && !empty($parameters['name']) && function_exists('get_option')) {
            $patternText = (string) get_option($parameters['name'], '');
        }

        if ($patternText === '' && !empty($this->prk_getways_sms_options->sms_text)) {
            $patternText = (string) $this->prk_getways_sms_options->sms_text;
        }

        return $patternText;
    }

    private function buildPatternAttributes($patternText, array $incoming)
    {
        $attributes = array();
        $used = array();

        if (!empty($patternText)) {
            if (preg_match_all('/#([a-zA-Z0-9_]+)#/', $patternText, $matches)) {
                foreach ($matches[1] as $placeholder) {
                    $varName = trim((string) $placeholder);
                    $key = strtolower($varName);

                    if ($varName === '' || in_array($key, $used, true)) {
                        continue;
                    }

                    $used[] = $key;

                    if (isset($incoming[$key]) && $incoming[$key] !== '') {
                        $attributes[$varName] = $this->sanitizeValue($incoming[$key], $key);
                        continue;
                    }

                    if ($key === 'token' && isset($incoming['code']) && $incoming['code'] !== '') {
                        $attributes[$varName] = $this->sanitizeValue($incoming['code'], $key);
                        continue;
                    }

                    if ($key === 'code' && isset($incoming['token']) && $incoming['token'] !== '') {
                        $attributes[$varName] = $this->sanitizeValue($incoming['token'], $key);
                        continue;
                    }
                }
            }
        }

        if (empty($attributes)) {
            foreach ($incoming as $key => $value) {
                if ($value === '' || $value === null) {
                    continue;
                }

                $attributes[$key] = $this->sanitizeValue($value, $key);
            }
        }

        return $attributes;
    }

    private function sanitizeValue($value, $key = '')
    {
        $value = trim(preg_replace('/\s+/u', ' ', (string) $value));

        if (in_array($key, array('orderurl', 'carturl', 'rateurl', 'url'), true)) {
            $value = preg_replace('#^https?://#i', '', $value);
        }

        if (function_exists('mb_strlen') && function_exists('mb_substr')) {
            if (mb_strlen($value, 'UTF-8') > 200) {
                $value = mb_substr($value, 0, 200, 'UTF-8');
            }

            return $value;
        }

        if (strlen($value) > 200) {
            $value = substr($value, 0, 200);
        }

        return $value;
    }

    private function normalizeMobile($mobile)
    {
        $digits = preg_replace('/\D+/', '', (string) $mobile);

        if (strpos($digits, '98') === 0 && strlen($digits) === 12) {
            return '0' . substr($digits, 2);
        }

        if (strpos($digits, '9') === 0 && strlen($digits) === 10) {
            return '0' . $digits;
        }

        return $digits;
    }

    private function normalizeLineNumber($line)
    {
        return preg_replace('/\D+/', '', (string) $line);
    }

    private function isSuccess($response)
    {
        if (empty($response) || !is_object($response)) {
            return false;
        }

        if (isset($response->status) && strtolower((string) $response->status) === 'success') {
            return true;
        }

        if (isset($response->success) && $response->success === true) {
            return true;
        }

        return false;
    }

    private function extractMessage($response, $fallback)
    {
        if (empty($response)) {
            return $fallback;
        }

        if (is_string($response)) {
            return $response;
        }

        if (is_object($response)) {
            if (!empty($response->messages)) {
                if (is_array($response->messages)) {
                    return implode(' | ', array_map('strval', $response->messages));
                }

                if (is_object($response->messages)) {
                    return $this->toJson($response->messages);
                }

                return (string) $response->messages;
            }

            if (!empty($response->message)) {
                return (string) $response->message;
            }

            if (!empty($response->error)) {
                return is_string($response->error) ? $response->error : $this->toJson($response->error);
            }
        }

        return $fallback;
    }

    private function responseData()
    {
        $responseData = new stdClass();
        $responseData->status = 0;
        $responseData->data = false;
        $responseData->message = '';

        return $responseData;
    }

    private function toJson($data)
    {
        if (function_exists('wp_json_encode')) {
            return wp_json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}