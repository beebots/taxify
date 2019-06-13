<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

require_once 'config.php';

use rk\Taxify\Communicator;
use rk\Taxify\Requests\VerifyAddress;
use rk\Taxify\Taxify;

$request = new VerifyAddress();

$request
    ->setStreet1('16201 E Indiana St')/* should change St to Ave */
    ->setCity('Spokane Valley')
    ->setRegion('WA')
    ->setPostalCode('99216');

try {
    /* initialize taxify */
    $taxify = new Taxify(API_KEY, Taxify::ENV_PROD, true);
    $comm   = new Communicator($taxify);
    $result = $request->execute($comm);

    var_dump($result);
} catch (Exception $e) {
    var_dump($e);
}