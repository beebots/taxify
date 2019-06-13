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
use rk\Taxify\Responses\CommitTax as Response;

class CommitTax implements RequestInterface
{

    use HasTaxRequestOptions;

    protected $document_key;

    /**
     * @param string $document_key
     */
    public function __construct(string $document_key)
    {
        $this->document_key = $document_key;
    }

    public function toArray(): array
    {
        $data = [
            'DocumentKey'          => $this->document_key,
            'CommittedDocumentKey' => $this->document_key,
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
        $return = $api->call('CommitTax', $this->toArray());

        return new Response($return);
    }

    public function getDocumentKey(): string
    {
        return $this->document_key;
    }

    public function setDocumentKey(string $key): self
    {
        $this->document_key = $key;

        return $this;
    }

}