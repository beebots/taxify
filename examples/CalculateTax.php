<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

require_once 'config.php';

use rk\Taxify\Communicator;
use rk\Taxify\Requests\CalculateTax;
use rk\Taxify\Taxify;
use rk\Taxify\Address;
use rk\Taxify\TaxLine;
use rk\Taxify\Code;

/* addresses */
$origin_address = new Address();
$origin_address
    ->setStreet1('16201 E Indiana Ave')
    ->setCity('Spokane Valley')
    ->setState('WA')
    ->setPostalCode('99216');

$destination_address = new Address();
$destination_address
    ->setStreet1('16201 E Indiana Ave')
    ->setCity('Spokane Valley')
    ->setState('WA')
    ->setPostalCode('99216');

/* line item */
$line = new TaxLine();
$line
    ->setQuantity(1)
    ->setItemKey('SKU001')
    ->setActualExtendedPrice(100)
    ->setItemDescription('Some Product')
    ->setItemTaxabilityCode(Code::CODE_FOOD);

/* calculate request */
$request = new CalculateTax();
$request
    ->setDocumentKey('Order001')
    ->setTaxDate(time())
    ->setCommitted(true)
    ->setOriginAddress($origin_address)
    ->setDestinationAddress($destination_address)
    ->addLine($line);

try {
    /* initialize taxify */
    $taxify = new Taxify(API_KEY, Taxify::ENV_PROD, true);
    $comm   = new Communicator($taxify);
    $result = $request->execute($comm);

    var_dump($result);
} catch (Exception $e) {
    var_dump($e);
}