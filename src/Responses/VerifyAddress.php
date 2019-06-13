<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

namespace rk\Taxify\Responses;

use rk\Taxify\Address;
use rk\Taxify\HasExtendedProperties;
use rk\Taxify\ResponseInterface;

class VerifyAddress implements ResponseInterface
{

    use HasExtendedProperties, ResponseStatusTrait;

    /** @var Address */
    protected $address;

    public function __construct(array $source = null)
    {
        if ($source === null) {
            $this->address = new Address();
        } else {
            $this->fromArray($source);
        }
    }

    public function fromArray(array $array)
    {
        $this->setResponseStatus($array['ResponseStatus']);

        if (!empty($array['Address'])) {
            $this->address = new Address();
            $this->address->loadFromArray($array['Address']);
        }

        if (!empty($array['ExtendedProperties'])) {
            $this->setExtendedProperties($array['ExtendedProperties']);
        }

        return $this;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function isVerified(): bool
    {
        return $this->isSuccessful() && $this->address->isValidated();
    }

}