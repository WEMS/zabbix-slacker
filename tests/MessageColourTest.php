<?php

use Wems\Zabbix\MessageColour;
use Wems\Zabbix\Params;

class MessageColourTest extends \PHPUnit\Framework\TestCase
{
    public function testColour()
    {
        $params = new Params();

        $messageColour = new MessageColour();

        $params->TRIGGER_STATUS = 'OK';
        $this->assertEquals('good', $messageColour->deriveFrom($params));

        $params->TRIGGER_STATUS = 'BAD';
        $params->TRIGGER_SEVERITY = 'Warning';
        $this->assertEquals('warning', $messageColour->deriveFrom($params));

        $params->TRIGGER_SEVERITY = 'HELL HAS BROKEN LOOSE';
        $this->assertEquals('danger', $messageColour->deriveFrom($params));
    }
}
