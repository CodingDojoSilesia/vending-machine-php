<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin\Command;

use PHPUnit\Framework\TestCase;

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
        $this->assertEquals('D', $command->getShortCode());
        $this->assertEquals(1, $command->getQuantity());
    }
}
