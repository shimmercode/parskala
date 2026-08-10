<?php
namespace PRKSMS\Gateways\Interfaces;

interface SMSInterface{
    function sendPattern($data);
}