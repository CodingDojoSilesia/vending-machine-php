<?php
declare(strict_types=1);

namespace VendingMachine\Application\Command;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;

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
        $this->assertInstanceOf(ShortCode::class, $command->getShortCode());
        $this->assertInstanceOf(Quantity::class, $command->getQuantity());
        $this->assertEquals('D', $command->getShortCode()->getCode());
        $this->assertEquals(3, $command->getQuantity()->getValue());
    }
}
