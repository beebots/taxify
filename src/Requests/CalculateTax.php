<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

namespace rk\Taxify\Requests;

use rk\Taxify\Address;
use rk\Taxify\Communicator;
use rk\Taxify\Discount;
use rk\Taxify\Exception;
use rk\Taxify\HasTaxRequestOptions;
use rk\Taxify\RequestInterface;
use rk\Taxify\ResponseInterface;
use rk\Taxify\Responses\CalculateTax as Response;
use rk\Taxify\Tag;
use rk\Taxify\TaxLine;

class CalculateTax implements RequestInterface
{

    use HasTaxRequestOptions;

    protected const ERR_NO_LINES = 'You must assign at least one Tax Request Line';
    protected const ERR_NO_DESTINATION = 'You must assign a Destination Address';
    protected const ERR_NO_DOC_KEY = 'You must assign a Document Key';

    /** @var string */
    protected $document_key;
    /** @var string */
    protected $tax_date;
    /** @var TaxLine[] */
    protected $lines = [];
    /** @var Address */
    protected $destination_address;
    /** @var Address|null */
    protected $origin_address;
    /** @var bool */
    protected $is_committed = false;
    /** @var string */
    protected $customer_key;
    /** @var string */
    protected $customer_taxability_code;
    /** @var string */
    protected $customer_registration_number;
    /** @var Tag[] */
    protected $tags = [];
    /** @var Discount[] */
    protected $discounts = [];

    public function toArray(): array
    {
        if (count($this->lines) === 0) {
            throw new Exception(self::ERR_NO_LINES);
        }

        if ($this->destination_address === null) {
            throw new Exception(self::ERR_NO_DESTINATION);
        }

        if ($this->document_key === '' || $this->document_key === false) {
            throw new Exception(self::ERR_NO_DOC_KEY);
        }

        $data = [
            'DocumentKey'                => (string)$this->document_key,
            'TaxDate'                    => empty($this->tax_date) ? date('Y-m-d') : $this->tax_date,
            'IsCommitted'                => $this->is_committed,
            'CustomerKey'                => (string)$this->customer_key,
            'CustomerTaxabilityCode'     => (string)$this->customer_taxability_code,
            'CustomerRegistrationNumber' => (string)$this->customer_registration_number,
            'DestinationAddress'         => $this->destination_address->toArray(),
            'Lines'                      => [],
            'Options'                    => [],
            'Tags'                       => [],
            'Discounts'                  => [],
        ];

        if ($this->origin_address !== null) {
            $data['OriginAddress'] = $this->origin_address->toArray();
        }

        foreach ($this->lines as $line) {
            $data['Lines'][] = $line->toArray();
        }

        if (!empty($this->tax_request_options)) {
            foreach ($this->tax_request_options as $tax_request_option) {
                $data['Options'][] = $tax_request_option->toArray();
            }
        }

        if (!empty($this->tags)) {
            foreach ($this->tags as $tag) {
                $data['Tags'][] = $tag->toArray();
            }
        }

        if (!empty($this->discounts)) {
            foreach ($this->discounts as $discount) {
                $data['Discounts'][] = $discount->toArray();
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
        $return = $api->call('CalculateTax', $this->toArray());

        return new Response($return);
    }

    public function getDocumentKey(): string
    {
        return $this->document_key;
    }

    public function setDocumentKey(string $document_key): self
    {
        $this->document_key = $document_key;

        return $this;
    }

    public function getTaxDate(): string
    {
        return $this->tax_date;
    }

    /**
     * @param mixed $tax_date
     * @return $this
     */
    public function setTaxDate($tax_date): self
    {
        if ($tax_date instanceof \DateTimeInterface) {
            $this->tax_date = $tax_date->format('Y-m-d');
        } elseif ($tax_date === null) {
            $this->tax_date = date('Y-m-d');
        } elseif (is_int($tax_date) || is_numeric($tax_date)) {
            $this->tax_date = date('Y-m-d', $tax_date);
        } elseif (is_string($tax_date)) {
            if (preg_match('/^\d{4}-\d\d-\d\d$/', $tax_date)) {
                $this->tax_date = $tax_date;
            } else {
                $this->tax_date = date('Y-m-d', strtotime($tax_date));
            }
        } else {
            throw new \InvalidArgumentException('Cannot transform to a date string: ' . var_export($tax_date, true));
        }

        return $this;
    }

    public function getDestinationAddress(): Address
    {
        return $this->destination_address;
    }

    public function setDestinationAddress(Address $destination_address): self
    {
        $this->destination_address = $destination_address;

        return $this;
    }

    public function getOriginAddress(): ?Address
    {
        return $this->origin_address;
    }

    public function setOriginAddress(?Address $origin_address): self
    {
        $this->origin_address = $origin_address;

        return $this;
    }

    public function isCommitted(): bool
    {
        return $this->is_committed;
    }

    public function setCommitted(bool $commit): self
    {
        $this->is_committed = $commit;

        return $this;
    }

    public function getCustomerKey(): string
    {
        return $this->customer_key;
    }

    public function setCustomerKey(string $key): self
    {
        $this->customer_key = $key;

        return $this;
    }

    public function getCustomerTaxabilityCode(): string
    {
        return $this->customer_taxability_code;
    }

    public function setCustomerTaxabilityCode(string $code): self
    {
        $this->customer_taxability_code = $code;

        return $this;
    }

    public function getCustomerRegistrationNumber(): string
    {
        return $this->customer_registration_number;
    }

    public function setCustomerRegistrationNumber(string $num): self
    {
        $this->customer_registration_number = $num;

        return $this;
    }

    public function addLine(TaxLine $line): self
    {
        $this->lines[] = $line;

        return $this;
    }

    /**
     * @return TaxLine[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    public function clearLines(): self
    {
        $this->lines = [];

        return $this;
    }

    public function addTag(Tag $tag): self
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    public function clearTags(): self
    {
        $this->tags = [];

        return $this;
    }

    public function addDiscount(Discount $discount): self
    {
        $this->discounts[] = $discount;

        return $this;
    }

    /**
     * @return Discount[]
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }

    public function clearDiscounts(): self
    {
        $this->discounts = [];

        return $this;
    }

}