#!/usr/bin/env php
<?php

use Slacker\Slack;
use Wems\Zabbix\MessageColour;
use Wems\Zabbix\ParamParser;
use Wems\Zabbix\SlackMessager;
use Wems\Zabbix\ZabbixUrl;

require __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$slackPoster = new Slack(getenv('SLACK_WEBHOOK'));
$slackMessager = new SlackMessager($slackPoster, new MessageColour(), new ZabbixUrl());

$params = (new ParamParser())->parse($argv[3]);
$slackMessager->send($argv[1], $argv[2], $params);
