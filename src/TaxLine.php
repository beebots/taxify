<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/23/15
 * Time: 7:20 AM
 */

namespace rk\Taxify;

class TaxLine
{

    use HasTaxRequestOptions, HasExtendedProperties;

    private $line_number;
    private $item_key;
    private $actual_extended_price;
    private $tax_included_in_price = false;
    private $quantity = 1;
    private $item_description;
    private $item_taxability_code;
    private $item_categories;
    private $item_tags;
    private $amount;
    private $exempt_amount;
    private $tax_rate;
    private $sales_tax_amount;

    /**
     * @param array|NULL $data
     */
    public function __construct(array $data = null)
    {
        if ($data !== null) {
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
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'LineNumber'          => (string)$this->line_number,
            'ItemKey'             => (string)$this->item_key,
            'ActualExtendedPrice' => $this->actual_extended_price ?? 0,
            'TaxIncludedInPrice'  => $this->tax_included_in_price,
            'Quantity'            => $this->quantity,
            'ItemDescription'     => (string)$this->item_description,
            'ItemTaxabilityCode'  => (string)$this->item_taxability_code,
            'ItemCategories'      => (string)$this->item_categories,
            'ItemTags'            => (string)$this->item_tags,
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

    public function getItemKey(): ?string
    {
        return $this->item_key;
    }

    public function setItemKey(string $item_key)
    {
        $this->item_key = $item_key;

        return $this;
    }

    public function getActualExtendedPrice(): ?int
    {
        return $this->actual_extended_price;
    }

    public function setActualExtendedPrice(int $actual_extended_price)
    {
        $this->actual_extended_price = $actual_extended_price;

        return $this;
    }

    public function isTaxIncludedInPrice(): bool
    {
        return $this->tax_included_in_price;
    }

    public function setTaxIncludedInPrice(bool $tax_included_in_price)
    {
        $this->tax_included_in_price = $tax_included_in_price;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;

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

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount)
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

}