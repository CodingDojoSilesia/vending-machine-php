<?php

declare(strict_types=1);

namespace Tests\Factory;

use PHPUnit\Framework\TestCase;
use VendingMachine\Command\BuyItemCommand;
use VendingMachine\Factory\CommandFactory;

class CommandFactoryTest extends TestCase
{
    public function testShouldReturnByItemCommand(): void
    {
        $this->markTestSkipped();

        $commandFactory = new CommandFactory();
        $command = $commandFactory->create('Q, Q, Q, Q, GET-B');

        self::assertInstanceOf(BuyItemCommand::class, $command);
    }
}
