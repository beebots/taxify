<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

namespace rk\Taxify;

trait HasTaxRequestOptions
{

    /** @var TaxRequestOption[] */
    protected $tax_request_options = [];

    /**
     * @return TaxRequestOption[]
     */
    public function getTaxRequestOptions(): array
    {
        return $this->tax_request_options;
    }

    /**
     * @param array $tax_request_options
     * @return $this
     */
    public function setTaxRequestOptions(array $tax_request_options)
    {
        $this->tax_request_options = [];

        foreach ($tax_request_options as $key => $value) {
            $this->tax_request_options[] = new TaxRequestOption($key, $value);
        }

        return $this;
    }

    public function addTaxRequestOption(TaxRequestOption $tax_request_option)
    {
        $this->tax_request_options[] = $tax_request_option;

        return $this;
    }

    public function removeTaxRequestOption(int $index)
    {
        if (array_key_exists($index, $this->tax_request_options)) {
            unset($this->tax_request_options[$index]);
        }

        return $this;
    }

    public function removeAllTaxRequestOptions()
    {
        $this->tax_request_options = [];

        return $this;
    }

}