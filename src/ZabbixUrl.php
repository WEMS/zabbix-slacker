<?php

namespace Wems\Zabbix;

class ZabbixUrl
{
    public function deriveFrom(Params $params): string
    {
        return sprintf(
            '%s/tr_events.php?triggerid=%d&eventid=%d',
            getenv('ZABBIX_BASE_URL'),
            $params->TRIGGER_ID,
            $params->EVENT_ID
        );
    }
}
