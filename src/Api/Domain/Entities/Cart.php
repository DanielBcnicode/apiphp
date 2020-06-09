<?php

declare(strict_types=1);

namespace App\Api\Domain\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;

class Cart
{
    private Uuid $id;
    private DateTime $createdAt;
    private Collection $items;

    public function __construct(Uuid $id, Item ...$items)
    {
        $this->items = new ArrayCollection();
        $this->id = $id;
        $this->createdAt = new DateTime();

        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items): void
    {
        $this->items = $items;
    }

    public function addItem(Item $item)
    {
        if (!$this->getItems()->contains($item)) {
            $this->getItems()->add($item);
            $item->setCart($this);
        }
    }
    public function removeItem(Item $item)
    {
        $this->items->remove($item->getId());
        if ($this->getItems()->contains($item)) {
            $this->getItems()->removeElement($item);
            $item->setCartId(null);
        }
    }
}