<?php

namespace App\Tests\Api\Application\Commands;

use App\Api\Application\Commands\PostItemCommand;
use App\Api\Application\Commands\PostItemHandler;
use App\Api\Domain\Repositories\CartRepository;
use App\Api\Domain\Repositories\ItemRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PostItemHandlerTest extends TestCase
{

    /** @var CartRepository|MockObject $cartRepository */
    private $cartRepository;
    /** @var ItemRepository|MockObject $itemRespository */
    private $itemRespository;

    protected function setUp()
    {
        $this->itemRespository = $this->getMockBuilder(ItemRepository::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->cartRepository = $this->getMockBuilder(CartRepository::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
    }

    /** @test */
    public function when_invoke_the_handle_the_cart_is_created()
    {
        $this->cartRepository
            ->expects($this->once())
            ->method("findById")
            ->willReturn(null);

        $this->itemRespository
            ->expects($this->once())
            ->method("findById")
            ->willReturn(null);

        $this->cartRepository
            ->expects($this->once())
            ->method("save");

        $handler = new PostItemHandler($this->cartRepository, $this->itemRespository);
        $command = new PostItemCommand(
            "1751c582-b8cf-44a2-80ae-735d486b7382",
            "1751c582-b8cf-44a2-80ae-735d486b7383",
            "name",
            "descrip",
            12.12
        );
        $handler($command);
    }
}
