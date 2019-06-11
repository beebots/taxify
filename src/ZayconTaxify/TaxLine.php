<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/23/15
 * Time: 7:20 AM
 */

namespace ZayconTaxify;

class TaxLine extends TaxifyBaseClass
{

    private $line_number;
    private $item_key;
    private $actual_extended_price;
    private $tax_included_in_price = false;
    private $quantity;
    private $item_description;
    private $item_taxability_code;
    private $item_categories;
    private $item_tags;
    private $amount;
    private $exempt_amount;
    private $tax_rate;
    private $sales_tax_amount;

    /** @var TaxRequestOption[] $tax_request_options */
    private $tax_request_options;

    /**
     * @param array|NULL $data
     */
    function __construct(array $data = null)
    {
        $this
            ->setLineNumber($data['LineNumber'])
            ->setItemKey($data['ItemKey'])
            ->setItemTaxabilityCode($data['ItemTaxabilityCode'])
            ->setAmount($data['Amount'])
            ->setExemptAmount($data['ExemptAmount'])
            ->setTaxRate($data['TaxRate'])
            ->setSalesTaxAmount($data['SalesTaxAmount'])
            ->setExtendedProperties($data['ExtendedProperties']);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'LineNumber'          => Taxify::toString($this->line_number),
            'ItemKey'             => Taxify::toString($this->item_key),
            'ActualExtendedPrice' => (empty($this->actual_extended_price) ? 0 : $this->actual_extended_price),
            'TaxIncludedInPrice'  => $this->tax_included_in_price,
            'Quantity'            => (empty($this->quantity) ? 0 : $this->quantity),
            'ItemDescription'     => Taxify::toString($this->item_description),
            'ItemTaxabilityCode'  => Taxify::toString($this->item_taxability_code),
            'ItemCategories'      => Taxify::toString($this->item_categories),
            'ItemTags'            => Taxify::toString($this->item_tags),
            'Options'             => [],
        ];

        if ($this->tax_request_options) {
            foreach ($this->tax_request_options as $tax_request_option) {
                $data['Request']['Options'][] = $tax_request_option->toArray();
            }
        }

        return $data;
    }

    /**
     * @return mixed
     */
    public function getLineNumber()
    {
        return $this->line_number;
    }

    /**
     * @param $line_number
     *
     * @return $this
     */
    public function setLineNumber($line_number)
    {
        $this->line_number = $line_number;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemKey()
    {
        return $this->item_key;
    }

    /**
     * @param $item_key
     *
     * @return $this
     */
    public function setItemKey($item_key)
    {
        $this->item_key = $item_key;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActualExtendedPrice()
    {
        return $this->actual_extended_price;
    }

    /**
     * @param $actual_extended_price
     *
     * @return $this
     */
    public function setActualExtendedPrice($actual_extended_price)
    {
        $actual_extended_price       = preg_replace('/[^0-9.-]*/', '', $actual_extended_price);
        $this->actual_extended_price = (is_numeric($actual_extended_price)) ? $actual_extended_price : 0;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isTaxIncludedInPrice()
    {
        return $this->tax_included_in_price;
    }

    /**
     * @param $tax_included_in_price
     *
     * @return $this
     */
    public function setTaxIncludedInPrice($tax_included_in_price)
    {
        $this->tax_included_in_price = ($tax_included_in_price === true) ? true : false;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $quantity       = preg_replace('/[^0-9.-]*/', '', $quantity);
        $this->quantity = (strlen($quantity) == 0) ? 0 : $quantity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemDescription()
    {
        return $this->item_description;
    }

    /**
     * @param $item_description
     *
     * @return $this
     */
    public function setItemDescription($item_description)
    {
        $this->item_description = $item_description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemTaxabilityCode()
    {
        return $this->item_taxability_code;
    }

    /**
     * @param $item_taxability_code
     *
     * @return $this
     */
    public function setItemTaxabilityCode($item_taxability_code)
    {
        $this->item_taxability_code = $item_taxability_code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemCategories()
    {
        return $this->item_categories;
    }

    /**
     * @param $item_categories
     *
     * @return $this
     */
    public function setItemCategories($item_categories)
    {
        $this->item_categories = $item_categories;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemTags()
    {
        return $this->item_tags;
    }

    /**
     * @param $item_tags
     *
     * @return $this
     */
    public function setItemTags($item_tags)
    {
        $this->item_tags = $item_tags;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     *
     * @return TaxLine
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSalesTaxAmount()
    {
        return $this->sales_tax_amount;
    }

    /**
     * @param mixed $sales_tax_amount
     *
     * @return TaxLine
     */
    public function setSalesTaxAmount($sales_tax_amount)
    {
        $this->sales_tax_amount = $sales_tax_amount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExemptAmount()
    {
        return $this->exempt_amount;
    }

    /**
     * @param mixed $exempt_amount
     *
     * @return TaxLine
     */
    public function setExemptAmount($exempt_amount)
    {
        $this->exempt_amount = $exempt_amount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxRate()
    {
        return $this->tax_rate;
    }

    /**
     * @param mixed $tax_rate
     *
     * @return TaxLine
     */
    public function setTaxRate($tax_rate)
    {
        $this->tax_rate = $tax_rate;

        return $this;
    }

    /**
     * @return TaxRequestOption[]
     */
    public function getTaxRequestOptions()
    {
        return $this->tax_request_options;
    }

    /**
     * @param array $tax_request_options
     *
     * @return $this
     */
    public function setTaxRequestOptions(array $tax_request_options)
    {
        $this->tax_request_options = [];
        foreach ($tax_request_options as $key => $value) {
            $tax_request_option          = new TaxRequestOption($key, $value);
            $this->tax_request_options[] = $tax_request_option;
        }

        return $this;
    }

    /**
     * @param TaxRequestOption $tax_request_option
     */
    public function addTaxRequestOption(TaxRequestOption $tax_request_option)
    {
        $this->tax_request_options[] = $tax_request_option;
    }

    /**
     * @param $index
     */
    public function removeTaxRequestOption($index)
    {
        if (array_key_exists($index, $this->tax_request_options)) {
            unset($this->tax_request_options[$index]);
        }
    }

    /**
     *
     */
    public function removeAllTaxRequestOptions()
    {
        $this->tax_request_options = null;
    }
}