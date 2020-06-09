<?php

declare(strict_types=1);

namespace App\Api\Domain\Entities;

use DateTime;
use Ramsey\Uuid\Uuid;

class Item
{
    private Uuid $id;
    private float $price;
    private string $name;
    private string $description;
    private Cart $cart;
    private DateTime $createdAt;

    public function __construct(
        Uuid $id,
        Cart $cart,
        string $name,
        string $description,
        float $price
    ) {
        $this->id = $id;
        $this->price = $price;
        $this->name = $name;
        $this->description = $description;
        $this->cart = $cart;
        $this->createdAt = new DateTime();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): void
    {
        $this->cart = $cart;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}