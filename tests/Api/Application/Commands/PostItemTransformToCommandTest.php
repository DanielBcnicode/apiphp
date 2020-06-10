<?php

namespace App\Tests\Api\Application\Commands;

use App\Api\Application\Commands\PostItemTransformToCommand;
use App\Api\Domain\Exceptions\ItemParameterNotFound;
use PHPUnit\Framework\TestCase;

class PostItemTransformToCommandTest extends TestCase
{
    /** @test */
    public function when_params_are_ok_then_a_object_is_returned()
    {
        $command = PostItemTransformToCommand::transform(
            [
                'cart_id' => "1751c582-b8cf-44a2-80ae-735d486b7383",
                'id' => "1751c582-b8cf-44a2-80ae-735d486b7382",
                'name' => "name",
                'description' => "description",
                'price' => 12.12
            ]
        );

        $this->assertEquals('1751c582-b8cf-44a2-80ae-735d486b7383', $command->cartId());
        $this->assertEquals('1751c582-b8cf-44a2-80ae-735d486b7382', $command->itemId());
        $this->assertEquals('name', $command->name());
        $this->assertEquals('description', $command->description());
        $this->assertEquals(12.12, $command->price());
    }

    /** @test */
    public function when_wrong_params_then_an_exception_thrown()
    {
        $this->expectException(ItemParameterNotFound::class);

        $command = PostItemTransformToCommand::transform(
            [
                'cart_id' => "1751c582-b8cf-44a2-80ae-735d486b7383",
                'description' => "description",
                'price' => 12.12
            ]
        );

    }
}
