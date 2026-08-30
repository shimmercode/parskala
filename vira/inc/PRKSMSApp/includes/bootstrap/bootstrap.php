<?php

require __DIR__."/autoloader.php";

 // instantiate the loader
use PRKSMSApp\Bootsrap\Autoloader;

$loader = new Autoloader;

 // register the autoloader
$loader->register();

// $loader->addNamespace('PRKSMSApp\\Gateways\\', __DIR__.'/../gateways/');
$loader->addNamespace('PRKSMSApp\\', __DIR__.'/../');