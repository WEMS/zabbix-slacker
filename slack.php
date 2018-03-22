#!/usr/bin/env php
<?php

use Slacker\Payload\Attachment;
use Slacker\Payload\Field;
use Slacker\Payload\Payload;

require __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$slackPoster = new \Slacker\SlackPoster(
    new \GuzzleHttp\Client(),
    getenv('SLACK_WEBHOOK')
);

$channel = $argv[1];
$title = $argv[2];
$params = explode("\n", $argv[3]);

$parsedParams = [];

foreach ($params as $item) {
    list($key, $value) = explode(':', $item);
    $key = trim($key);
    $value = trim($value);
    $$key = $value;
    $parsedParams[$key] = $value;
}

/** @var $HOST */
/** @var $TRIGGER_NAME */
/** @var $TRIGGER_STATUS */
/** @var $TRIGGER_SEVERITY */
/** @var $TRIGGER_ID */
/** @var $DATETIME */
/** @var $ITEM_ID */
/** @var $ITEM_NAME */
/** @var $ITEM_KEY */
/** @var $ITEM_VALUE */
/** @var $EVENT_ID */

if ($TRIGGER_STATUS === 'OK') {
    $colour = 'good';
} elseif (strtolower($TRIGGER_SEVERITY) === 'warning') {
    $colour = 'warning';
} else {
    $colour = 'danger';
}

$url = sprintf('%s/tr_events.php?triggerid=%d&eventid=%d', getenv('ZABBIX_BASE_URL'), $TRIGGER_ID, $EVENT_ID);

$payload = new Payload();
$payload->username = 'Zabbix';
$payload->channel = $channel;

// specific message setup
$payload->text = $title;

$attachment = new Attachment();
$attachment->color = $colour;
$attachment->title_link = $url;
$attachment->title = $TRIGGER_NAME . ' (' . $ITEM_VALUE . ')';

$field = new Field();
$field->title = $HOST;
$field->value = 'Severity: ' . $TRIGGER_SEVERITY;
$attachment->addField($field);

$payload->addAttachment($attachment);

// send the message
$slackPoster->send($payload);
