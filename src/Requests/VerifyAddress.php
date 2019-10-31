<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

namespace rk\Taxify\Requests;

use rk\Taxify\Address;
use rk\Taxify\Communicator;
use rk\Taxify\Exception;
use rk\Taxify\HasTaxRequestOptions;
use rk\Taxify\RequestInterface;
use rk\Taxify\ResponseInterface;
use rk\Taxify\Responses\VerifyAddress as Response;

class VerifyAddress implements RequestInterface
{

    use HasTaxRequestOptions;

    /** @var string */
    protected $street1;
    /** @var string|null */
    protected $street2;
    /** @var string */
    protected $city;
    /** @var string */
    protected $region;
    /** @var string */
    protected $postal_code;
    /** @var string */
    protected $country;

    /**
     * @param Address|null $address
     */
    public function __construct(Address $address = null)
    {
        if ($address) {
            $this->fromAddress($address);
        }
    }

    public function fromAddress(Address $address)
    {
        $this->setStreet1($address->getStreet1())
            ->setStreet2($address->getStreet2())
            ->setCity($address->getCity())
            ->setRegion($address->getRegion())
            ->setPostalCode($address->getPostalCode())
            ->setCountry($address->getCountry());

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'Street1'    => (string)$this->street1,
            'Street2'    => (string)$this->street2,
            'City'       => (string)$this->city,
            'Region'     => (string)$this->region,
            'PostalCode' => (string)$this->postal_code,
            'Country'    => (string)$this->country,
            'Options'    => [],
        ];

        if ($this->tax_request_options) {
            foreach ($this->tax_request_options as $tax_request_option) {
                $data['Options'][] = $tax_request_option->toArray();
            }
        }

        return $data;
    }

    /**
     * @param Communicator $api
     * @return Response
     * @throws Exception
     */
    public function execute(Communicator $api): ResponseInterface
    {
        $return = $api->call('VerifyAddress', $this->toArray());

        return new Response($return);
    }

    public function getStreet1(): string
    {
        return $this->street1;
    }

    public function setStreet1(string $street1): self
    {
        $this->street1 = $street1;

        return $this;
    }

    public function getStreet2(): ?string
    {
        return $this->street2;
    }

    public function setStreet2(string $street2 = null): self
    {
        $this->street2 = $street2;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getPostalCode(): string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

}