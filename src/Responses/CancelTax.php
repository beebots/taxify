<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

namespace rk\Taxify\Responses;

use rk\Taxify\HasExtendedProperties;
use rk\Taxify\ResponseInterface;

class CancelTax implements ResponseInterface
{

    use HasExtendedProperties, ResponseStatusTrait;

    public function __construct(array $array)
    {
        $this->setResponseStatus($array['ResponseStatus']);

        if (!empty($array['ExtendedProperties'])) {
            $this->setExtendedProperties($array['ExtendedProperties']);
        }
    }

}