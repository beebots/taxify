<?php
/**
 * Copyright © 2019 by Wood Street, Inc. All Rights reserved.
 */

namespace rk\Taxify\Requests;

use rk\Taxify\Communicator;
use rk\Taxify\Exception;
use rk\Taxify\HasTaxRequestOptions;
use rk\Taxify\RequestInterface;
use rk\Taxify\ResponseInterface;
use rk\Taxify\Responses\GetCodes as Response;

class GetCodes implements RequestInterface
{

    use HasTaxRequestOptions;

    protected $code_type;

    /**
     * @param string $code_type
     */
    public function __construct(string $code_type = '')
    {
        $this->code_type = $code_type;
    }

    public function toArray(): array
    {
        $data = [
            'CodeType' => $this->code_type,
        ];

        if (!empty($this->tax_request_options)) {
            foreach ($this->tax_request_options as $option) {
                $data['Options'][] = $option->toArray();
            }
        }

        return $data;
    }

    /**
     * @param Communicator $api
     * @return Response
     * @throws Exception
     */
    public function execute(Communicator $api): ResponseInterface
    {
        $return = $api->call('GetCodes', $this->toArray());

        return new Response($return);
    }

    public function getCodeType(): string
    {
        return $this->code_type;
    }

    public function setCodeType(string $type): self
    {
        $this->code_type = $type;

        return $this;
    }

}