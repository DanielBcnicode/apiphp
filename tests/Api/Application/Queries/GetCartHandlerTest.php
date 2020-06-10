<?php

namespace App\Tests\Api\Application\Queries;

use App\Api\Application\Queries\GetCartHandler;
use App\Api\Application\Queries\GetCartQuery;
use App\Api\Domain\Entities\Cart;
use App\Api\Domain\Entities\Item;
use App\Api\Domain\Repositories\CartRepository;
use App\Api\Domain\Repositories\ItemRepository;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetCartHandlerTest extends TestCase
{
    const CART_UUID = "1751c582-b8cf-44a2-80ae-735d486b7382";
    const ITEM_UUID = "1751c582-b8cf-44a2-80ae-735d486b7381";
    const NAME= "Name1";
    const DESCRIPTION = "Description1";
    const PRICE = 12.12;

    /** @var CartRepository|MockObject $cartRepository */
    private $cartRepository;

    protected function setUp()
    {
        $this->cartRepository = $this->getMockBuilder(CartRepository::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
    }


    /** @test */
    public function when_handler_is_called_then_a_cart_is_returned()
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

        $this->cartRepository
            ->expects($this->once())
            ->method("findById")
            ->willReturn($cart);

        $handler = new GetCartHandler($this->cartRepository);
        $query = new GetCartQuery(self::CART_UUID);
        $response = $handler($query);

        $this->assertNotEmpty($response->getResponse());
    }
}
