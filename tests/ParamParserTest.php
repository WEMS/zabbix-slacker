<?php

use Wems\Zabbix\ParamParser;

class ParamParserTest extends \PHPUnit\Framework\TestCase
{
    public function testParsesParams()
    {
        $testFile = __DIR__ . '/../temp.txt';

        $params = (new ParamParser())->parse(file_get_contents($testFile));

        $this->assertEquals(498, $params->EVENT_ID);
        $this->assertEquals('Warning', $params->TRIGGER_SEVERITY);
    }
}
