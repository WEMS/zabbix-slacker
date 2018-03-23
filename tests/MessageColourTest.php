<?php

use Wems\Zabbix\MessageColour;
use Wems\Zabbix\Params;

class MessageColourTest extends \PHPUnit\Framework\TestCase
{
    /** @var Params */
    private $params;

    /** @var MessageColour */
    private $messageColour;

    public function setUp()
    {
        $this->params = new Params();
        $this->messageColour = new MessageColour();
    }

    public function testOK()
    {
        $this->params->TRIGGER_STATUS = 'OK';
        $this->assertColour(MessageColour::GOOD);
    }

    public function testInformation()
    {
        $this->params->TRIGGER_SEVERITY = 'Information';
        $this->assertColour(MessageColour::INFO);
    }

    public function testWarning()
    {
        $this->params->TRIGGER_SEVERITY = 'Warning';
        $this->assertColour(MessageColour::WARNING);
    }

    public function testAverage()
    {
        $this->params->TRIGGER_SEVERITY = 'Average';
        $this->assertColour(MessageColour::AVERAGE);
    }

    public function testHigh()
    {
        $this->params->TRIGGER_SEVERITY = 'High';
        $this->assertColour(MessageColour::HIGH);
    }

    public function testDisaster()
    {
        $this->params->TRIGGER_SEVERITY = 'Disaster';
        $this->assertColour(MessageColour::DISASTER);
    }

    public function testUnknown()
    {
        $this->params->TRIGGER_SEVERITY = 'FooBar';
        $this->assertColour(MessageColour::WARNING);
    }

    private function assertColour(string $colour)
    {
        $this->assertEquals($colour, $this->messageColour->deriveFrom($this->params));
    }
}
