<?php

require __DIR__."/autoloader.php";

 // instantiate the loader
use PRKSMS\Bootsrap\Autoloader;

$loader = new Autoloader;

 // register the autoloader
$loader->register();

$loader->addNamespace('PRKSMS\\Gateways\\', __DIR__.'/../gateways-sms/');