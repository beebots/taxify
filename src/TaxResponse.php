<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/23/15
 * Time: 3:08 PM
 */

namespace rk\Taxify;

class TaxResponse
{

    use HasExtendedProperties;

    private $document_key;
    private $sales_tax_amount;
    private $tax_jurisdiction_summary;
    private $response_status;
    private $effective_tax_date;
    private $is_committed = false;
    private $effective_tax_address_type;
    private $raw_json;

    /** @var Address $destination_address */
    private $destination_address;

    /** @var Address $origin_address */
    private $origin_address;

    /** @var Address $effective_tax_address */
    private $effective_tax_address;

    /** @var TaxJurisdiction[] $tax_jurisdictions */
    private $tax_jurisdictions = [];

    /** @var TaxLine[] $tax_lines */
    private $lines = [];

    /**
     * @param string|null $json
     */
    public function __construct(string $json = null)
    {
        if ($json !== null) {
            $this->loadFromJson($json);
        }
    }

    /**
     * @param $json
     */
    public function loadFromJson(string $json)
    {
        $this->raw_json = $json;
        $this->loadFromArray(json_decode($json, true));
    }

    /**
     * @param array $data
     */
    public function loadFromArray(array $data)
    {
        $this
            ->setDocumentKey($data['DocumentKey'])
            ->setSalesTaxAmount($data['SalesTaxAmount'])
            ->setTaxJurisdictionSummary($data['TaxJurisdictionSummary'])
            ->setResponseStatus($data['ResponseStatus'])
            ->setEffectiveTaxDate($data['EffectiveTaxDate'])
            ->setIsCommitted($data['IsCommitted'])
            ->setEffectiveTaxAddressType($data['EffectiveTaxAddressType'])
            ->setExtendedProperties($data['ExtendedProperties']);

        $this->destination_address = new Address();
        $this->destination_address->loadFromArray($data['DestinationAddress']);

        $this->origin_address = new Address();
        $this->origin_address->loadFromArray($data['OriginAddress']);

        $this->effective_tax_address = new Address();
        $this->effective_tax_address->loadFromArray($data['EffectiveTaxAddress']);

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
    }

    public function getDocumentKey(): string
    {
        return $this->document_key;
    }

    public function setDocumentKey(string $document_key)
    {
        $this->document_key = $document_key;

        return $this;
    }

    public function getSalesTaxAmount(): float
    {
        return $this->sales_tax_amount;
    }

    public function setSalesTaxAmount(float $sales_tax_amount)
    {
        $this->sales_tax_amount = $sales_tax_amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getTaxJurisdictionSummary(): string
    {
        return $this->tax_jurisdiction_summary;
    }

    public function setTaxJurisdictionSummary(string $tax_jurisdiction_summary)
    {
        $this->tax_jurisdiction_summary = $tax_jurisdiction_summary;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponseStatus()
    {
        return $this->response_status;
    }

    /**
     * @param mixed $response_status
     *
     * @return TaxResponse
     */
    public function setResponseStatus($response_status)
    {
        $this->response_status = $response_status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEffectiveTaxDate()
    {
        return $this->effective_tax_date;
    }

    /**
     * @param mixed $effective_tax_date
     *
     * @return TaxResponse
     */
    public function setEffectiveTaxDate($effective_tax_date)
    {
        $this->effective_tax_date = $effective_tax_date;

        return $this;
    }

    /**
     * @deprecated
     */
    public function isIsCommitted(): bool
    {
        return $this->is_committed;
    }

    public function isCommitted(): bool
    {
        return $this->is_committed;
    }

    public function setIsCommitted(bool $is_committed)
    {
        $this->is_committed = $is_committed;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEffectiveTaxAddressType()
    {
        return $this->effective_tax_address_type;
    }

    /**
     * @param mixed $effective_tax_address_type
     *
     * @return TaxResponse
     */
    public function setEffectiveTaxAddressType($effective_tax_address_type)
    {
        $this->effective_tax_address_type = $effective_tax_address_type;

        return $this;
    }

    /**
     * @return TaxJurisdiction[]
     */
    public function getTaxJurisdictions()
    {
        return $this->tax_jurisdictions;
    }

    /**
     * @return TaxLine[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param bool|FALSE $as_array
     *
     * @return mixed
     */
    public function getRawJson($as_array = false)
    {
        if ($as_array) {
            return json_decode($this->raw_json, true);
        }

        return $this->raw_json;
    }
}