<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

namespace rk\Taxify\Responses;

use rk\Taxify\Address;
use rk\Taxify\HasExtendedProperties;
use rk\Taxify\ResponseInterface;
use rk\Taxify\TaxJurisdiction;
use rk\Taxify\TaxLine;

class CalculateTax implements ResponseInterface
{

    use HasExtendedProperties, ResponseStatusTrait;

    /** @var string */
    protected $document_key;
    /** @var float */
    protected $sales_tax_amount;
    /** @var string */
    protected $tax_jurisdiction_summary;
    /** @var Address */
    protected $destination_address;
    /** @var Address|null */
    protected $origin_address;
    /** @var TaxJurisdiction[] */
    protected $tax_jurisdictions = [];
    /** @var TaxLine[] */
    protected $lines = [];
    /** @var array */
    protected $errors;
    /** @var string */
    protected $effective_tax_date;
    /** @var string */
    protected $customer_taxability_code;
    /** @var bool */
    protected $is_committed = false;
    /** @var string */
    protected $effective_tax_address_type;
    /** @var Address|null */
    protected $effective_tax_address;

    public function __construct(array $source = null)
    {
        if ($source) {
            $this->fromArray($source);
        }
    }

    public function fromArray(array $array): void
    {
        $this->setDocumentKey($array['DocumentKey'])
            ->setSalesTaxAmount($array['SalesTaxAmount'])
            ->setTaxJurisdictionSummary($array['TaxJurisdictionSummary'])
            ->setResponseStatus((bool)$array['ResponseStatus'])
            ->setEffectiveTaxDate($array['EffectiveTaxDate'])
            ->setIsCommitted($array['IsCommitted'])
            ->setEffectiveTaxAddressType($array['EffectiveTaxAddressType'])
            ->setExtendedProperties($array['ExtendedProperties']);

        $this->destination_address = new Address();
        $this->destination_address->loadFromArray($array['DestinationAddress']);

        $this->origin_address = new Address();
        $this->origin_address->loadFromArray($array['OriginAddress']);

        $this->effective_tax_address = new Address();
        $this->effective_tax_address->loadFromArray($array['EffectiveTaxAddress']);

        if (!empty($data['TaxJurisdictionDetails'])) {
            $this->tax_jurisdictions = [];

            foreach ($data['TaxJurisdictionDetails'] as $detail) {
                $this->tax_jurisdictions[] = new TaxJurisdiction($detail);
            }
        }

        if (!empty($data['TaxLineDetails'])) {
            $this->lines = [];

            foreach ($data['TaxLineDetails'] as $detail) {
                $this->lines[] = new TaxLine($detail);
            }
        }

        if (!empty($array['ExtendedProperties'])) {
            $this->setExtendedProperties($array['ExtendedProperties']);
        }
    }

    public function getDocumentKey(): string
    {
        return $this->document_key;
    }

    public function setDocumentKey(string $key): self
    {
        $this->document_key = $key;

        return $this;
    }

    public function getSalesTaxAmount(): float
    {
        return $this->sales_tax_amount;
    }

    public function setSalesTaxAmount(float $amount): self
    {
        $this->sales_tax_amount = $amount;

        return $this;
    }

    public function getTaxJurisdictionSummary(): string
    {
        return $this->tax_jurisdiction_summary;
    }

    public function setTaxJurisdictionSummary(string $summary): self
    {
        $this->tax_jurisdiction_summary = $summary;

        return $this;
    }

    public function getDestinationAddress(): Address
    {
        return $this->destination_address;
    }

    public function setDestinationAddress(Address $address): self
    {
        $this->destination_address = $address;

        return $this;
    }

    public function getOriginAddress(): ?Address
    {
        return $this->origin_address;
    }

    public function setOriginAddress(?Address $address): self
    {
        $this->origin_address = $address;

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    public function getEffectiveTaxDate(): string
    {
        return $this->effective_tax_date;
    }

    public function setEffectiveTaxDate(string $date): self
    {
        $this->effective_tax_date = $date;

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

    public function isIsCommitted(): bool
    {
        return $this->is_committed;
    }

    public function setIsCommitted(bool $commit): self
    {
        $this->is_committed = $commit;

        return $this;
    }

    public function getEffectiveTaxAddressType(): string
    {
        return $this->effective_tax_address_type;
    }

    public function setEffectiveTaxAddressType(string $type): self
    {
        $this->effective_tax_address_type = $type;

        return $this;
    }

    public function getEffectiveTaxAddress(): ?Address
    {
        return $this->effective_tax_address;
    }

    public function setEffectiveTaxAddress(?Address $address): self
    {
        $this->effective_tax_address = $address;

        return $this;
    }

    public function getTaxJurisdictions(): array
    {
        return $this->tax_jurisdictions;
    }

    public function addTaxJurisdiction(TaxJurisdiction $jurisdiction): self
    {
        $this->tax_jurisdictions[] = $jurisdiction;

        return $this;
    }

    public function getLines(): array
    {
        return $this->lines;
    }

    public function addLine(TaxLine $line): self
    {
        $this->lines[] = $line;

        return $this;
    }


}