<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

namespace rk\Taxify\Responses;

trait ResponseStatusTrait
{

    protected $response_status = false;

    public function getResponseStatus(): bool
    {
        return $this->response_status;
    }

    /**
     * @param mixed $status
     * @return $this
     */
    public function setResponseStatus($status): self
    {
        $this->response_status = $status === 'Success'
            || filter_var($status, FILTER_VALIDATE_BOOLEAN);

        return $this;
    }

    public function isSuccessful(): bool
    {
        return $this->response_status;
    }

    public function isFailure(): bool
    {
        return !$this->response_status;
    }
}