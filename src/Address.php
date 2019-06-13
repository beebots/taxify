<?php
/**
 * Created by PhpStorm.
 * User: Tony DeStefano
 * Date: 10/22/15
 * Time: 11:23 AM
 */

namespace rk\Taxify;

class Address
{

    use HasTaxRequestOptions, HasExtendedProperties;

    public const CALL_VERIFY_ADDRESS = 'VerifyAddress';

    public const VALIDATION_SUCCESS = 'Validated';
    public const VALIDATION_FAILURE = 'NotValidated';

    public const ERROR_TAXIFY_OBJ_NOT_PRESENT = 'You must initialize with a Taxify object to perform this call';

    /** @var string|null */
    protected $first_name;
    /** @var string|null */
    protected $last_name;
    /** @var string|null */
    protected $company;
    /** @var string|null */
    protected $street1;
    /** @var string|null */
    protected $street2;
    /** @var string|null */
    protected $city;
    /** @var string */
    protected $region;
    /** @var string */
    protected $postal_code;
    /** @var string|null */
    protected $county;
    /** @var string */
    protected $country;
    /** @var string|null */
    protected $email;
    /** @var string|null */
    protected $phone;
    /** @var string|null */
    protected $residential_or_business_type;
    /** @var bool */
    protected $validation_status = false;
    /** @var Address[] $address_suggestions */
    protected $address_suggestions = [];

    public function __construct(array $source = null)
    {
        if ($source !== null) {
            $this->loadFromArray($source);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [
            'FirstName'  => (string)$this->first_name,
            'LastName'   => (string)$this->last_name,
            'Company'    => (string)$this->company,
            'Street1'    => (string)$this->street1,
            'Street2'    => (string)$this->street2,
            'City'       => (string)$this->city,
            'Region'     => (string)$this->region,
            'PostalCode' => (string)$this->postal_code,
            'Options'    => [],
        ];

        if ($this->tax_request_options) {
            foreach ($this->tax_request_options as $tax_request_option) {
                $data['Request']['Options'][] = $tax_request_option->toArray();
            }
        }

        return $data;
    }

    /**
     * @param array $data
     */
    public function loadFromArray(array $data): void
    {
        foreach ($data as $key => $val) {
            if ($key !== 'ExtendedProperties') {
                $method = 'set' . $key;

                if (method_exists($this, $method)) {
                    $this->$method($val);
                }
            }
        }

        if (!empty($data['ExtendedProperties']) && $data['ExtendedProperties'] !== null) {
            $this->clearExtendedProperties();

            foreach ($data['ExtendedProperties'] as $key => $val) {
                $this->addExtendedProperty($key, $val);
            }
        }
    }

    public function isValidated(): bool
    {
        return $this->validation_status;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name = null): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name = null): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company = null): self
    {
        $this->company = $company;

        return $this;
    }

    public function getStreet1(): ?string
    {
        return $this->street1;
    }

    public function setStreet1(string $street1 = null): self
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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city = null): self
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

    /**
     * @deprecated
     */
    public function getState(): string
    {
        return $this->region;
    }

    /**
     * @deprecated
     */
    public function setState(string $state): self
    {
        $this->setRegion($state);

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

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function setCounty(string $county = null): self
    {
        $this->county = $county;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email = null): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone = null): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getResidentialOrBusinessType(): ?string
    {
        return $this->residential_or_business_type;
    }

    public function setResidentialOrBusinessType(string $type = null): self
    {
        $this->residential_or_business_type = $type;

        return $this;
    }

    public function getValidationStatus(): bool
    {
        return $this->validation_status;
    }

    public function setValidationStatus(string $status): self
    {
        $this->validation_status = $status === self::VALIDATION_SUCCESS;

        return $this;
    }

    /**
     * @return Address[]
     */
    public function getAddressSuggestions(): array
    {
        return $this->address_suggestions;
    }

    /**
     * @param array[]|Address[] $addresses
     *
     * @return Address
     */
    public function setAddressSuggestions(array $addresses): self
    {
        $this->address_suggestions = array_map(static function ($row) {
            return $row instanceof self
                ? $row
                : new static($row);
        }, $addresses);

        return $this;
    }

    public function clearObjectProperties(): void
    {
        $this->address_suggestions = [];
        $this->removeAllTaxRequestOptions();
        $this->clearExtendedProperties();
    }

}