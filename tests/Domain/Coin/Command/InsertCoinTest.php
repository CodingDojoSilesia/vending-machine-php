<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin\Command;

use PHPUnit\Framework\TestCase;

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
        $this->assertEquals('D', $command->getShortCode());
        $this->assertEquals(1, $command->getQuantity());
    }
}
