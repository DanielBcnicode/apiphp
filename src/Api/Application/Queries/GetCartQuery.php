<?php

namespace App\Api\Application\Queries;

use Ramsey\Uuid\Uuid;

class GetCartQuery
{
    private Uuid $cartId;

    public function __construct(Uuid $cartId)
    {
        $this->cartId = $cartId;
    }

    public function cartId(): Uuid
    {
        return $this->cartId;
    }
}