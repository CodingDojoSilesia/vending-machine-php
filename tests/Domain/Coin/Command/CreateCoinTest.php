<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin\Command;

use PHPUnit\Framework\TestCase;

class CreateCoinTest extends TestCase
{
    public function testInstance(): CreateCoin
    {
        $command = CreateCoin::withData('D',  3);
        $this->assertInstanceOf(CreateCoin::class, $command);

        return $command;
    }

    /**
     * @param CreateCoin $command
     *
     * @depends testInstance
     */
    public function testGetters(CreateCoin $command): void
    {
        $this->assertEquals('D', $command->getShortCode());
        $this->assertEquals(3, $command->getQuantity());
    }
}
