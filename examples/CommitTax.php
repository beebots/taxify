<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

require_once 'config.php';

use rk\Taxify\Communicator;
use rk\Taxify\Requests\CommitTax;
use rk\Taxify\Taxify;

$request = new CommitTax('Order001');

try {
    /* initialize taxify */
    $taxify = new Taxify(API_KEY, Taxify::ENV_PROD, true);
    $comm   = new Communicator($taxify);
    $result = $request->execute($comm);

    var_dump($result);
} catch (Exception $e) {
    var_dump($e);
}