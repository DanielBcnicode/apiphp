<?php

namespace App\Api\Domain\Repositories;

use App\Api\Domain\Entities\Cart;
use Ramsey\Uuid\Uuid;

interface CartRepository
{
    public function findById(Uuid $uuid): ?Cart;
    public function save(Cart $cart);
}