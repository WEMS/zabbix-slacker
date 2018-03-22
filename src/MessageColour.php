<?php

namespace Wems\Zabbix;

class MessageColour
{
    public function deriveFrom(Params $params): string
    {
        if ($params->TRIGGER_STATUS === 'OK') {
            $colour = 'good';
        } elseif (strtolower($params->TRIGGER_SEVERITY) === 'warning') {
            $colour = 'warning';
        } else {
            $colour = 'danger';
        }

        return $colour;
    }
}
