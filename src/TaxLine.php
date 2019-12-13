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
            'ActualExtendedPrice' => $this->actual_extended_price ?? $this->amount * $this->quantity,
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

    public function getActualExtendedPrice(): ?float
    {
        return $this->actual_extended_price;
    }

    /**
     * The total price of the line item (quantity * unit_price); calculated
     * if not provided.
     *
     * @param float $price
     * @return $this
     */
    public function setActualExtendedPrice(float $price)
    {
        $this->actual_extended_price = $price;

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

    /**
     * @return int The number of items in the line item
     */
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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @param float|null $amount The unit_price of the line-item.
     * @return $this
     */
    public function setAmount(float $amount = null)
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSalesTaxAmount(): ?float
    {
        return $this->sales_tax_amount;
    }

    public function setSalesTaxAmount(float $amount = null)
    {
        $this->sales_tax_amount = $amount;

        return $this;
    }

    public function getExemptAmount(): ?float
    {
        return $this->exempt_amount;
    }

    public function setExemptAmount(float $exempt_amount = null)
    {
        $this->exempt_amount = $exempt_amount;

        return $this;
    }

    public function getTaxRate(): ?float
    {
        return $this->tax_rate;
    }

    public function setTaxRate(float $tax_rate = null)
    {
        $this->tax_rate = $tax_rate;

        return $this;
    }

}