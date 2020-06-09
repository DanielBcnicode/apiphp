<?php

namespace App\Tests\Api\Domain\Entities;

use App\Api\Domain\Entities\Cart;
use App\Api\Domain\Entities\Item;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CartTest extends TestCase
{

    const CART_UUID = "1751c582-b8cf-44a2-80ae-735d486b7382";
    const ITEM_UUID = "1751c582-b8cf-44a2-80ae-735d486b7381";
    const NAME= "Name1";
    const DESCRIPTION = "Description1";
    const PRICE = 12.12;

    /**
     * @test
     */
    public function when_a_cart_is_create_then_attributes_dont_change()
    {

        $cart = new Cart(Uuid::fromString(self::CART_UUID));
        $item = new Item(
            Uuid::fromString(self::ITEM_UUID),
            $cart,
            self::NAME,
            self::DESCRIPTION,
            self::PRICE
        );
        $cart->addItem($item);

        $this->assertEquals(self::CART_UUID, $cart->getId()->toString());
        $this->assertEquals(1, $cart->getItems()->count());
        $this->assertEquals(self::ITEM_UUID, $cart->getItems()->first()->getId()->toString());
    }
}
