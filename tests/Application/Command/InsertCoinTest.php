<?php
declare(strict_types=1);

namespace VendingMachine\Application\Coin\Command;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;

class InsertCoinTest extends TestCase
{
    public function testInstance(): InsertCoin
    {
        $command = InsertCoin::withData('D', 1);
        $this->assertInstanceOf(InsertCoin::class, $command);

        return $command;
    }

    /**
     * @param InsertCoin $command
     *
     * @depends testInstance
     */
    public function testGetters(InsertCoin $command)
    {
        $this->assertInstanceOf(ShortCode::class, $command->getShortCode());
        $this->assertInstanceOf(Quantity::class, $command->getQuantity());
        $this->assertEquals('D', $command->getShortCode()->getCode());
        $this->assertEquals(1, $command->getQuantity()->getValue());
    }
}
