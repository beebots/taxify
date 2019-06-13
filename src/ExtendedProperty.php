<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 11:45 AM
 */

namespace rk\Taxify;

class ExtendedProperty
{

    private $key;
    private $value;

    public function __construct(string $key, string $value)
    {
        $this->setKey($key);
        $this->setValue($value);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key)
    {
        $this->key = $key;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value)
    {
        $this->value = $value;

        return $this;
    }
}