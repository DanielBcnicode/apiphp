<?php

namespace App\Api\Application\Commands;

use App\Api\Domain\Exceptions\ItemParameterNotFound;

class PostItemTransformToCommand
{
    static function transform(array $data): PostItemCommand
    {
        $cartId = key_exists('cart_id', $data) ? $data['cart_id'] : null;
        $itemId = key_exists('id', $data) ? $data['id'] : null;
        $name = key_exists('name', $data) ? $data['name'] : null;
        $description = key_exists('description', $data) ? $data['description'] : "(none)";
        $price = key_exists('price', $data) ? $data['price'] : null;

        if ($cartId === null || $itemId === null || $name === null || $price === null) {
            throw new ItemParameterNotFound();
        }

        return new PostItemCommand($itemId, $cartId, $name, $description, $price);
    }
}