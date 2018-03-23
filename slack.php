#!/usr/bin/env php
<?php

use Slacker\Slack;
use Wems\Zabbix\GraphService;
use Wems\Zabbix\MessageColour;
use Wems\Zabbix\ParamParser;
use Wems\Zabbix\SlackMessenger;
use Wems\Zabbix\ZabbixUrl;

require __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$graphService = new GraphService();
$slackPoster = new Slack(getenv('SLACK_WEBHOOK'));
$slackMessager = new SlackMessenger($slackPoster, new MessageColour(), new ZabbixUrl(), $graphService);

$params = (new ParamParser())->parse($argv[3]);
$slackMessager->send($argv[1], $argv[2], $params);
