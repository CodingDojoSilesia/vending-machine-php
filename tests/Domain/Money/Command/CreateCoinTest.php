<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Money\Command;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Money\Money;
use VendingMachine\Domain\Money\Quantity;
use VendingMachine\Domain\Money\ShortCode;

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
