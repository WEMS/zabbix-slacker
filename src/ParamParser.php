<?php

namespace Wems\Zabbix;

class ParamParser
{
    public function parse(string $params): Params
    {
        $params = explode("\n", trim($params));

        $paramsObject = new Params();

        foreach ($params as $item) {
            list($key, $value) = explode(':', $item);
            $key = trim($key);
            $value = trim($value);
            $paramsObject[$key] = $value;
        }

        return $paramsObject;
    }
}
