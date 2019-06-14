<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

namespace rk\Taxify;

abstract class StringEntity
{

    protected $value = '';

    public function __construct(string $string)
    {
        $this->setString($string);
    }

    public function getString(): string
    {
        return $this->value;
    }

    public function setString(string $string)
    {
        $this->value = $string;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'string' => $this->value,
        ];
    }

    public function __toString()
    {
        return $this->value;
    }

}