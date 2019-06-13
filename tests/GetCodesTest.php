<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

use PHPUnit\Framework\TestCase;
use rk\Taxify\Communicator;
use rk\Taxify\Requests\GetCodes;
use rk\Taxify\Taxify;

class GetCodesTest extends TestCase
{

    protected $taxify;
    protected $communicator;

    protected function setUp()
    {
        $this->taxify       = new Taxify(API_KEY, Taxify::ENV_PROD);
        $this->communicator = new Communicator($this->taxify);
    }

    public function testBasic()
    {
        $request = new GetCodes();
        $result  = $request->execute($this->communicator);

        $this->assertGreaterThan(0, $result->getCodes());
    }

    public function testWithParam()
    {
        $request = new GetCodes('Item');
        $result  = $request->execute($this->communicator);

        $this->assertGreaterThan(0, $result->getCodes());
    }
}
