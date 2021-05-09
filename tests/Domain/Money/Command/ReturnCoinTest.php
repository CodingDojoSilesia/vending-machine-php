<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Money\Command;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Money\Quantity;
use VendingMachine\Domain\Money\ShortCode;

class ReturnCoinTest extends TestCase
{
    public function testInstance(): ReturnCoin
    {
        $command = ReturnCoin::withData('D', 1);
        $this->assertInstanceOf(ReturnCoin::class, $command);

        return $command;
    }

    /**
     * @param ReturnCoin $command
     *
     * @depends testInstance
     */
    public function testGetters(ReturnCoin $command)
    {
        $this->assertInstanceOf(ShortCode::class, $command->getShortCode());
        $this->assertInstanceOf(Quantity::class, $command->getQuantity());
        $this->assertEquals('D', $command->getShortCode()->getCode());
        $this->assertEquals(1, $command->getQuantity()->getValue());
    }
}
