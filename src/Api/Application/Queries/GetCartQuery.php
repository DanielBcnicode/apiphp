<?php

namespace App\Api\Application\Queries;

use App\Api\Domain\Exceptions\WrongParameter;
use Ramsey\Uuid\Uuid;

class GetCartQuery
{
    private string $cartId;

    public function __construct(string $cartId)
    {
        if (!Uuid::isValid($cartId)) {
            throw new WrongParameter("The Cart Id must be a valid uuid.");
        }

        $this->cartId = $cartId;
    }

    public function cartId(): string
    {
        return $this->cartId;
    }
}