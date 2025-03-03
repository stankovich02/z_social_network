<?php

use NovaLite\Application;
use NovaLite\Config\Config as NovaConfig;


require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

require_once __DIR__ . '/../helpers.php';



$config = [
    'db' => NovaConfig::get('database'),
    'log' => NovaConfig::get('logging')
];

$app = new Application(dirname(__DIR__),$config);

