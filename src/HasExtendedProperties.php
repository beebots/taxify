<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

namespace rk\Taxify;

trait HasExtendedProperties
{

    /** @var ExtendedProperty[] $extended_properties */
    protected $extended_properties = [];

    public function setExtendedProperties(array $data = null)
    {
        if (!empty($data)) {
            $this->extended_properties = [];

            foreach ($data as $key => $val) {
                $this->extended_properties[] = new ExtendedProperty($key, $val);
            }
        }

        return $this;
    }

    /**
     * @return ExtendedProperty[]
     */
    public function getExtendedProperties(): array
    {
        return $this->extended_properties;
    }

    public function clearExtendedProperties()
    {
        $this->extended_properties = [];

        return $this;
    }

    public function addExtendedProperty($key, $val)
    {
        $this->extended_properties[] = new ExtendedProperty($key, $val);

        return $this;
    }

    public function removeExtendedProperty(int $index)
    {
        if (array_key_exists($index, $this->extended_properties)) {
            unset($this->extended_properties[$index]);
        }

        return $this;
    }

}