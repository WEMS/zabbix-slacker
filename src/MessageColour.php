<?php

namespace Wems\Zabbix;

class MessageColour
{
    // some taken from Zabbix UI, some are Slack standards
    const GOOD = 'good';
    const INFO = '#7499FF';
    const WARNING = 'warning';
    const AVERAGE = '#FFA059';
    const HIGH = '#E97659';
    const DISASTER = 'danger';

    public function deriveFrom(Params $params): string
    {
        if ($params->TRIGGER_STATUS === 'OK') {
            return self::GOOD;
        }

        switch (strtolower($params->TRIGGER_SEVERITY)) {
            case 'information':
                return self::INFO;
            case 'warning':
                return self::WARNING;
            case 'average':
                return self::AVERAGE;
            case 'high':
                return self::HIGH;
            case 'disaster':
                return self::DISASTER;
            default:
                return self::WARNING;
        }
    }
}
