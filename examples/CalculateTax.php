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
    ->setStreet1('303 E Patrick St')
    ->setCity('Frederick')
    ->setRegion('MD')
    ->setPostalCode(21701);

$destination_address = new Address();
$destination_address
    ->setStreet1('303 E Patrick St')
    ->setCity('Frederick')
    ->setRegion('MD')
    ->setPostalCode(21701);

/* line item */
$line = new TaxLine();
$line
    ->setItemKey('SKU001')
    ->setQuantity(3)
    ->setAmount(9.99)
    // ->setActualExtendedPrice(9.99)
    ->setItemDescription('Some Product');

/* calculate request */
$request = new CalculateTax();
$request
    ->setDocumentKey('Order001')
    ->setTaxDate(time())
    ->setCommitted(false)
    ->setOriginAddress($origin_address)
    ->setDestinationAddress($destination_address)
    ->addLine($line);

try {
    /* initialize taxify */
    $taxify = new Taxify(API_KEY, Taxify::ENV_PROD, true);
    $comm   = new Communicator($taxify);
    $result = $request->execute($comm);

    print_r($result);
} catch (Exception $e) {
    print_r($e);
}