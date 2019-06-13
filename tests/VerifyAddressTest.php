<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

use rk\Taxify\Address;
use rk\Taxify\Communicator;
use rk\Taxify\Requests\VerifyAddress;
use rk\Taxify\Taxify;

class VerifyAddressTest extends \PHPUnit\Framework\TestCase
{

    protected const ADDR_STREET1 = '303 E Patrick St';
    protected const ADDR_STREET2 = '';
    protected const ADDR_CITY = 'Frederick';
    protected const ADDR_REGION = 'MD';
    protected const ADDR_POSTAL = '21701';
    protected const ADDR_COUNTRY = 'US';

    protected const CORRECT_POSTAL = '21701-5614';

    /** @var Taxify */
    protected $taxify;

    protected function setUp()
    {
        $this->taxify = new Taxify(API_KEY, Taxify::ENV_PROD);
    }

    public function testFromSetters()
    {
        $request = new VerifyAddress();

        $request->setStreet1(self::ADDR_STREET1);
        $request->setStreet2(self::ADDR_STREET2);
        $request->setCity(self::ADDR_CITY);
        $request->setRegion(self::ADDR_REGION);
        $request->setPostalCode(self::ADDR_POSTAL);
        $request->setCountry(self::ADDR_COUNTRY);

        $this->assertEquals(self::ADDR_STREET1, $request->getStreet1());
        $this->assertEquals(self::ADDR_STREET2, $request->getStreet2());
        $this->assertEquals(self::ADDR_CITY, $request->getCity());
        $this->assertEquals(self::ADDR_REGION, $request->getRegion());
        $this->assertEquals(self::ADDR_POSTAL, $request->getPostalCode());
        $this->assertEquals(self::ADDR_COUNTRY, $request->getCountry());

        return $request;
    }

    /**
     * @depends testFromSetters
     * @param VerifyAddress $request
     * @return VerifyAddress
     */
    public function testToArray(VerifyAddress $request)
    {
        $array = $request->toArray();

        $this->assertEquals(self::ADDR_STREET1, $array['Street1']);
        $this->assertEquals(self::ADDR_STREET2, $array['Street2']);
        $this->assertEquals(self::ADDR_CITY, $array['City']);
        $this->assertEquals(self::ADDR_REGION, $array['Region']);
        $this->assertEquals(self::ADDR_POSTAL, $array['PostalCode']);
        $this->assertEquals(self::ADDR_COUNTRY, $array['Country']);

        return $request;
    }

    public function testFromAddress()
    {
        $address = new Address();

        $address->setStreet1(self::ADDR_STREET1);
        $address->setStreet2(self::ADDR_STREET2);
        $address->setCity(self::ADDR_CITY);
        $address->setState(self::ADDR_REGION);
        $address->setPostalCode(self::ADDR_POSTAL);
        $address->setCountry(self::ADDR_COUNTRY);

        $request = new VerifyAddress($address);

        $this->assertEquals($address->getStreet1(), $request->getStreet1());
        $this->assertEquals($address->getStreet2(), $request->getStreet2());
        $this->assertEquals($address->getCity(), $request->getCity());
        $this->assertEquals($address->getState(), $request->getRegion());
        $this->assertEquals($address->getPostalCode(), $request->getPostalCode());
        $this->assertEquals($address->getCountry(), $request->getCountry());
    }

    /**
     * @depends testToArray
     * @param VerifyAddress $request
     */
    public function testVerify(VerifyAddress $request)
    {
        $comm   = new Communicator($this->taxify);
        $result = $request->execute($comm);

        $this->assertTrue($result->isSuccessful());
        $this->assertTrue($result->isVerified());

        $address = $result->getAddress();

        $this->assertTrue($address->isValidated());
        $this->assertEquals(self::ADDR_STREET1, $address->getStreet1());
        $this->assertEquals(self::ADDR_STREET2, $address->getStreet2());
        $this->assertEquals(self::ADDR_CITY, $address->getCity());
        $this->assertEquals(self::ADDR_REGION, $address->getRegion());
        $this->assertEquals(self::CORRECT_POSTAL, $address->getPostalCode());
        $this->assertEquals(self::ADDR_COUNTRY, $address->getCountry());
        $this->assertEquals('Frederick', $address->getCounty());
        $this->assertEquals('Business', $address->getResidentialOrBusinessType());
    }
}
