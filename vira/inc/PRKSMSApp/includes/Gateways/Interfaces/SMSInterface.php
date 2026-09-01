<?php
namespace PRKSMSApp\Gateways\Interfaces;

interface SMSInterface{
    public function sendBulkSMS($text, $mobiles);
    public function sendVerifySMS($parameters, $templateId, $mobile);
    public function getCredit();
}