<?php

namespace App\Tests\Api\Application\Commands;

use App\Api\Application\Commands\PostItemCommand;
use PHPUnit\Framework\TestCase;

class PostItemCommandTest extends TestCase
{
    /**
     * @test
     */
    public function when_create_a_command_the_attributes_are_dont_change()
    {
        $command = new PostItemCommand("1751c582-b8cf-44a2-80ae-735d486b7382", "1751c582-b8cf-44a2-80ae-735d486b7383", "name", "descrip", 12.12);

        $this->assertEquals("1751c582-b8cf-44a2-80ae-735d486b7382", $command->itemId());
        $this->assertEquals("1751c582-b8cf-44a2-80ae-735d486b7383", $command->cartId());
        $this->assertEquals("name", $command->name());
        $this->assertEquals("descrip", $command->description());
        $this->assertEquals(12.12, $command->price());

    }
}
