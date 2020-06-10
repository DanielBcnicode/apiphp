<?php

declare(strict_types=1);

namespace App\Api\Application\Queries;

use App\Api\Domain\Entities\Cart;
use App\Api\Domain\Entities\Item;
use App\Api\Domain\Exceptions\ItemNotExist;
use App\Api\Domain\Repositories\CartRepository;
use Symfony\Component\HttpFoundation\Response;

class GetCartHandler
{
    /** @var CartRepository */
    private CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * @throws ItemNotExist
     */
    public function __invoke(GetCartQuery $query)
    {
        $cart = $this->cartRepository->findById($query->cartId());
        if (null === $cart) {
            return new GetCartResponse([], Response::HTTP_NOT_FOUND);
        }
        return new GetCartResponse($this->cartToArray($cart), 0);
    }

    private function cartToArray(Cart $cart): array
    {
        $items = [];
        $data = [
            "id" => $cart->getId()->toString(),
            "created_at" => $cart->getCreatedAt()->format(DATE_ATOM)
        ];
        /** @var Item $item */
        foreach ($cart->getItems() as $item) {
            $items[] = [
                "id" => $item->getId()->toString(),
                "cart_id" => $item->getCart()->getId()->toString(),
                "name" => $item->getName(),
                "description" => $item->getDescription(),
                "price" => $item->getPrice(),
                "created_at" => $item->getCreatedAt()->format(DATE_ATOM)
            ];
        }
        $data["items"] = $items;

        return $data;
    }

}