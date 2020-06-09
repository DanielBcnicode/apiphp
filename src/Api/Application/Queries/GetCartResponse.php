<?php

namespace App\Api\Application\Queries;

class GetCartResponse
{
    private int $errorCode;
    private array $response;

    public function __construct(array $response, int $errorCode)
    {
        $this->response = $response;
        $this->errorCode = $errorCode;
    }

    public function getResponse(): array
    {
        return $this->response;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }
}