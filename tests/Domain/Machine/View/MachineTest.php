<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Machine\View;

use PHPUnit\Framework\TestCase;
use VendingMachine\ObjectMother\Coin\CoinViewMother;

class MachineTest extends TestCase
{
    public function testInstance(): Machine
    {
        $machine = new Machine(100, 10, [
            CoinViewMother::dime(10)
        ]);
        $this->assertInstanceOf(Machine::class, $machine);

        return $machine;
    }

    /**
     * @param Machine $machine
     *
     * @depends testInstance
     */
    public function testGetters(Machine $machine)
    {
        $this->assertEquals(100, $machine->getTotalBalance());
        $this->assertEquals(10, $machine->getClientBalance());
        $this->assertCount(1, $machine->getCoins());
    }
}
