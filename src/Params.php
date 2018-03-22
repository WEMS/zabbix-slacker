<?php

namespace Wems\Zabbix;

/**
 * @property $HOST
 * @property $TRIGGER_NAME
 * @property $TRIGGER_STATUS
 * @property $TRIGGER_SEVERITY
 * @property $TRIGGER_ID
 * @property $DATETIME
 * @property $ITEM_ID
 * @property $ITEM_NAME
 * @property $ITEM_KEY
 * @property $ITEM_VALUE
 * @property $EVENT_ID
 */
class Params implements \ArrayAccess
{
    /** @var array */
    private $data = [];

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->data[$offset];
        }

        return null;
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    public function __set($key, $value)
    {
        $this->offsetSet($key, $value);
    }
}
