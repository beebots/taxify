<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

namespace rk\Taxify\Responses;

use rk\Taxify\Code;
use rk\Taxify\ResponseInterface;

class GetCodes implements ResponseInterface
{

    /** @var string */
    protected $code_type;
    /** @var Code[] */
    protected $codes;

    public function __construct(array $array)
    {
        $this
            ->setCodeType($array['CodeType'])
            ->setCodes($array['Codes']);
    }

    public function getCodeType(): string
    {
        return $this->code_type;
    }

    public function setCodeType(string $type): self
    {
        $this->code_type = $type;

        return $this;
    }

    public function getCodes(): array
    {
        return $this->codes;
    }

    public function setCodes(array $codes): self
    {
        $this->codes = array_map(static function ($code) {
            return $code instanceof Code
                ? $code
                : new Code($code);
        }, $codes);

        return $this;
    }

}