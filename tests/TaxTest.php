<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

use PHPUnit\Framework\TestCase;
use rk\Taxify\Address;
use rk\Taxify\Communicator;
use rk\Taxify\Requests\CalculateTax;
use rk\Taxify\Requests\CancelTax;
use rk\Taxify\Requests\CommitTax;
use rk\Taxify\Taxify;
use rk\Taxify\TaxLine;

class TaxTest extends TestCase
{

    public const DOCUMENT_KEY = 'TestOrder001';
    public const TAX_DATE     = 1560444314;
    public const TAX_DATE_FMT = '2019-06-13';

    protected $taxify;
    protected $communicator;

    protected function setUp()
    {
        $this->taxify       = new Taxify(API_KEY, Taxify::ENV_PROD);
        $this->communicator = new Communicator($this->taxify);
    }

    public function testCalculate(): CalculateTax
    {
        $request = new CalculateTax();

        $request->setDocumentKey(self::DOCUMENT_KEY)
            ->setTaxDate(self::TAX_DATE);

        $destination = new Address();

        $destination->setCompany('Wood Street, Inc');
        $destination->setStreet1('303 E Patrick St');
        $destination->setCity('Frederick');
        $destination->setRegion('MD');
        $destination->setPostalCode('21701');

        $request->setDestinationAddress($destination);

        $line = new TaxLine();

        $line->setLineNumber('1')
            ->setItemKey('Widget010')
            ->setItemDescription('ACME Widget #10')
            ->setItemTaxabilityCode('GENERALMERCHANDISE')
            ->setActualExtendedPrice(100);

        $request->addLine($line);

        $this->assertEquals(self::DOCUMENT_KEY, $request->getDocumentKey());
        $this->assertEquals(self::TAX_DATE_FMT, $request->getTaxDate());
        $this->assertCount(1, $request->getLines());

        return $request;
    }

    /**
     * @depends testCalculate
     * @param CalculateTax $request
     * @return CalculateTax
     */
    public function testCalculateToArray(CalculateTax $request): CalculateTax
    {
        $array = $request->toArray();

        $this->assertEquals(self::DOCUMENT_KEY, $array['DocumentKey']);
        $this->assertEquals(self::TAX_DATE_FMT, $array['TaxDate']);
        $this->assertFalse($array['IsCommitted']);
        $this->assertCount(1, $array['Lines']);

        return $request;
    }

    /**
     * @depends testCalculateToArray
     * @param CalculateTax $request
     */
    public function testCalculateTaxes(CalculateTax $request)
    {
        $result = $request->execute($this->communicator);

        $this->assertTrue($result->isSuccessful());
        $this->assertGreaterThan(0, $result->getSalesTaxAmount());
    }

    /**
     * @depends testCalculateTaxes
     */
    public function testCommit()
    {
        $request = new CommitTax(self::DOCUMENT_KEY);
        $result  = $request->execute($this->communicator);

        $this->assertEquals($request->getDocumentKey(), self::DOCUMENT_KEY);
        $this->assertTrue($result->isSuccessful());
    }

    /**
     * @depends testCalculateTaxes
     */
    public function testCancel()
    {
        $request = new CancelTax(self::DOCUMENT_KEY);
        $result  = $request->execute($this->communicator);

        $this->assertEquals($request->getDocumentKey(), self::DOCUMENT_KEY);
        $this->assertTrue($result->isSuccessful());
    }

}
