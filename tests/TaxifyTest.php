<?php

use \rk\Taxify\Taxify;

class TaxifyTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @expectedException \PHPUnit\Framework\Error\Warning
     */
    public function testIsDev()
    {
        $taxify = new Taxify(null, Taxify::ENV_DEV);
        $this->assertTrue($taxify->isDev());
    }

    public function testIsProd()
    {
        $taxify = new Taxify(null, Taxify::ENV_PROD);
        $this->assertTrue($taxify->isProd());
    }

    public function testGetEnvironment()
    {
        $taxify = new Taxify(null, Taxify::ENV_PROD);
        $this->assertEquals(Taxify::ENV_PROD, $taxify->getEnvironment());
    }

    /**
     * @depends testIsProd
     */
    public function testSetEnvironment()
    {
        $taxify = new Taxify();
        $taxify->setEnvironment(Taxify::ENV_PROD);
        $this->assertTrue($taxify->isProd());
    }

    public function testGetApiKey()
    {
        $api_key = "api-0123456789-xoxoxo";
        $taxify  = new Taxify($api_key);
        $this->assertEquals($api_key, $taxify->getApiKey());
    }

    /**
     * @depends testGetApiKey
     */
    public function testSetApiKey()
    {
        $api_key = "api-0123456789-xoxoxo";
        $taxify  = new Taxify();
        $taxify->setApiKey($api_key);

        $this->assertEquals($api_key, $taxify->getApiKey());
    }

    /**
     * @expectedException \PHPUnit\Framework\Error\Warning
     */
    public function testGetDevUrl()
    {
        $dev_url = Taxify::DEV_URL;
        $taxify  = new Taxify(null, Taxify::ENV_DEV);
        $this->assertEquals($dev_url, $taxify->getUrl());
    }

    public function testGetProdUrl()
    {
        $prod_url = Taxify::PROD_URL;
        $taxify   = new Taxify(null, Taxify::ENV_PROD);
        $this->assertEquals($prod_url, $taxify->getUrl());
    }

    public function testIsDebugMode()
    {
        $taxify = new Taxify();
        $this->assertFalse($taxify->isDebugMode());
    }

    /**
     * @depends testIsDebugMode
     */
    public function testSetDebugMode()
    {
        $taxify = new Taxify(null, null, false);
        $taxify->setDebugMode(true);
        $this->assertTrue($taxify->isDebugMode());
    }

}