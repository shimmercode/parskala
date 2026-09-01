<?php
// خطایابی روشن
error_reporting(E_ALL);
ini_set('display_errors', 1);

// توکن مدیانا
$token = 'AedbKvnLH/BKjEf1e7Y1C97AUDOxN4ocjz2hHy19vZQ=';
// $url = 'https://api.mediana.ir/v1/sms/credit';
// $url = 'https://api.mediana.ir/api/v1/credit';
$url = 'https://api.mediana.ir/v1/account/credit';

// curl تست
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Accept: application/json'
]);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// نمایش نتیجه
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'http_code' => $httpcode,
    'response' => json_decode($response, true),
]);