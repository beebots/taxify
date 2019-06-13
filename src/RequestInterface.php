<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

namespace rk\Taxify;

interface RequestInterface
{

    /**
     * Converts the request into a Taxify API compatible array structure.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Executes the request on the API client.
     *
     * @param Communicator $api
     * @return ResponseInterface
     */
    public function execute(Communicator $api): ResponseInterface;

}