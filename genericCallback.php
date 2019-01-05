#!/usr/bin/env php
<?php

use Wems\Zabbix\ParamParser;

require __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$params = (new ParamParser())->parse($argv[3]);

$postWarning = new GuzzleHttp\Client();
$postWarning->post(getenv('GENERIC_CALLBACK_URI'), [
    \GuzzleHttp\RequestOptions::JSON => [
        'params' => $params,
    ],
]);
