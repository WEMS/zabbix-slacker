<?php

namespace Wems\Zabbix;

use Slacker\Payload\Attachment;
use Slacker\Payload\Field;
use Slacker\Slack;

class SlackMessager
{
    /** @var Slack */
    private $slack;

    /** @var MessageColour */
    private $messageColour;

    /** @var ZabbixUrl */
    private $zabbixUrl;

    public function __construct(Slack $slack, MessageColour $messageColour, ZabbixUrl $zabbixUrl)
    {
        $this->slack = $slack;
        $this->messageColour = $messageColour;
        $this->zabbixUrl = $zabbixUrl;
    }

    public function send(string $channel, string $title, Params $params)
    {
        $this->slack->username('Zabbix');
        $this->slack->channel($channel);
        $this->slack->message($title);

        $attachment = new Attachment();
        $attachment->color = $this->messageColour->deriveFrom($params);
        $attachment->title_link = $this->zabbixUrl->deriveFrom($params);
        $attachment->title = $params->TRIGGER_NAME . ' (' . $params->ITEM_VALUE . ')';

        $field = new Field();
        $field->title = $params->HOST;
        $field->value = 'Severity: ' . $params->TRIGGER_SEVERITY;
        $attachment->addField($field);

        $this->slack->attachment($attachment);

        $this->slack->send();
    }
}
