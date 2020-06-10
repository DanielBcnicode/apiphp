<?php

namespace App\Api\Application\Commands;

use App\Api\Domain\Exceptions\WrongParameter;
use Ramsey\Uuid\Uuid;

class PostItemCommand
{

    private string $itemId;
    private string $cartId;
    private string $name;
    private string $description;
    private float $price;

    public function __construct(string $itemId, string $cartId, string $name, string $description, float $price)
    {
        $this->itemId = $itemId;
        $this->cartId = $cartId;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->checkParameters();
    }

    public function itemId(): string
    {
        return $this->itemId;
    }

    public function cartId(): string
    {
        return $this->cartId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function price(): float
    {
        return $this->price;
    }

    private function checkParameters()
    {
        if (!Uuid::isValid($this->itemId)) {
            throw new WrongParameter("The Item Id must be a valid uuid.");
        }
        if (!Uuid::isValid($this->cartId)) {
            throw new WrongParameter("The Cart Id must be a valid uuid.");
        }
        if (strlen($this->name) < 3) {
            throw new WrongParameter("The item Name must have 3 or more characters");
        }
    }
}
