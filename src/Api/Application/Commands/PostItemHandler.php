<?php

declare(strict_types=1);

namespace App\Api\Application\Commands;

use App\Api\Domain\Entities\Cart;
use App\Api\Domain\Entities\Item;
use App\Api\Domain\Repositories\CartRepository;
use App\Api\Domain\Repositories\ItemRepository;
use Ramsey\Uuid\Uuid;

class PostItemHandler
{
    /** @var CartRepository */
    private CartRepository $cartRepository;
    /** @var ItemRepository */
    private ItemRepository $itemRepository;

    public function __construct(CartRepository $cartRepository, ItemRepository $itemRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->itemRepository = $itemRepository;
    }

    public function __invoke(PostItemCommand $command)
    {
        $cart = $this->cartRepository->findById(Uuid::fromString($command->cartId()));
        if ($cart === null) {
            $cart = new Cart(Uuid::fromString($command->cartId()));
        }

        $item = $this->itemRepository->findById(Uuid::fromString($command->itemId()));
        if ($item === null) {
            $item = new Item(Uuid::fromString($command->itemId()), $cart, $command->name(), $command->description(), $command->price());
        } else {
            //We update the content
            $item->setName($command->name());
            $item->setDescription($command->description());
            $item->setPrice($command->price());
        }

        $cart->addItem($item);
        $this->cartRepository->save($cart);
    }
}
