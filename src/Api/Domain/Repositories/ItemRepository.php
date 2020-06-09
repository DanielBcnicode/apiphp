<?php

namespace App\Api\Domain\Repositories;

use App\Api\Domain\Entities\Item;
use Ramsey\Uuid\Uuid;

interface ItemRepository
{
    public function findById(Uuid $machineId): ?Item;
    public function findAllByCart(Uuid $cartId): ?array;
}