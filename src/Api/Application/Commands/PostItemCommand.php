<?php

namespace App\Api\Application\Commands;

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
}