<?php

class TaxifyTest extends PHPUnit_Framework_TestCase
{

    public function testIsDev()
    {
        $taxify = new \ZayconTaxify\Taxify(null, \ZayconTaxify\Taxify::ENV_DEV);
        $this->assertTrue($taxify->isDev());
    }

    public function testIsProd()
    {
        $taxify = new \ZayconTaxify\Taxify(null, \ZayconTaxify\Taxify::ENV_PROD);
        $this->assertTrue($taxify->isProd());
    }

    public function testGetEnvironment()
    {
        $taxify = new \ZayconTaxify\Taxify(null, \ZayconTaxify\Taxify::ENV_PROD);
        $this->assertEquals(\ZayconTaxify\Taxify::ENV_PROD, $taxify->getEnvironment());
    }

    /**
     * @depends testIsProd
     */
    public function testSetEnvironment()
    {
        $taxify = new \ZayconTaxify\Taxify();
        $taxify->setEnvironment(\ZayconTaxify\Taxify::ENV_PROD);
        $this->assertTrue($taxify->isProd());
    }

    public function testGetApiKey()
    {
        $api_key = "api-0123456789-xoxoxo";
        $taxify  = new \ZayconTaxify\Taxify($api_key);
        $this->assertEquals($api_key, $taxify->getApiKey());
    }

    /**
     * @depends testGetApiKey
     */
    public function testSetApiKey()
    {
        $api_key = "api-0123456789-xoxoxo";
        $taxify  = new \ZayconTaxify\Taxify();
        $taxify->setApiKey($api_key);

        $this->assertEquals($api_key, $taxify->getApiKey());
    }

    public function testGetDevUrl()
    {
        $dev_url = \ZayconTaxify\Taxify::DEV_URL;
        $taxify  = new \ZayconTaxify\Taxify(null, \ZayconTaxify\Taxify::ENV_DEV);
        $this->assertEquals($dev_url, $taxify->getUrl());
    }

    public function testGetProdUrl()
    {
        $prod_url = \ZayconTaxify\Taxify::PROD_URL;
        $taxify   = new \ZayconTaxify\Taxify(null, \ZayconTaxify\Taxify::ENV_PROD);
        $this->assertEquals($prod_url, $taxify->getUrl());
    }

    public function testIsDebugMode()
    {
        $taxify = new \ZayconTaxify\Taxify();
        $this->assertFalse($taxify->isDebugMode());
    }

    /**
     * @depends testIsDebugMode
     */
    public function testSetDebugMode()
    {
        $taxify = new \ZayconTaxify\Taxify(null, null, false);
        $taxify->setDebugMode(true);
        $this->assertTrue($taxify->isDebugMode());
    }

    public function testToString()
    {
        $taxify = new \ZayconTaxify\Taxify();

        $null_string     = null;
        $not_null_string = "Hey! I'm a string!";

        $this->assertEquals(null, $taxify->toString($null_string));
        $this->assertEquals($not_null_string, $taxify->toString($not_null_string));
    }

    /**
     * @depends testSetDebugMode
     */
    public function testPrintDebugInfo()
    {
        $taxify = new \ZayconTaxify\Taxify(null, null, true);

        $title = "Title";
        $data  = [];

        $this->assertTrue($taxify->printDebugInfo($title, $data));

        $taxify->setDebugMode(false);

        $this->assertFalse($taxify->printDebugInfo($title, $data));
    }
}