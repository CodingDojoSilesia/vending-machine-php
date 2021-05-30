<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Machine;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;
use VendingMachine\Domain\Shared\Exception\BalanceException;

class MachineTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testInstance(): Machine
    {
        $machine = new Machine();

        $this->assertInstanceOf(Machine::class, $machine);

        return $machine;
    }

    /**
     * @param Machine $machine
     *
     * @depends testInstance
     */
    public function testBalanceAfterCreated(Machine $machine)
    {
        $this->assertEquals(0, $machine->getTotalBalance()->getAmount());
        $this->assertEquals(0, $machine->getClientBalance()->getAmount());
    }

    /**
     * @param Machine $machine
     *
     * @depends testInstance
     */
    public function testCoinsAfterCreated(Machine $machine)
    {
        $this->assertCount(0, $machine->getCoins());
    }

    /**
     * @param Machine $machine
     *
     * @return Machine
     *
     * @depends testInstance
     */
    public function testCreateCoin(Machine $machine): Machine
    {
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(10);

        $machine->createCoin($shortCode, $quantity);
        $this->assertCount(1, $machine->getCoins());
        $this->assertArrayHasKey((string)$shortCode, $machine->getCoins());
        $coin = $machine->getCoins()[(string)$shortCode];
        $this->assertInstanceOf(Coin::class, $coin);
        $this->assertEquals(10, $coin->getQuantity()->count());
        $this->assertEquals(0, $machine->getClientBalance()->getAmount());
        $this->assertEquals(100, $machine->getTotalBalance()->getAmount());

        return $machine;
    }

    /**
     * @param Machine $machine
     *
     * @return Machine
     *
     * @depends testCreateCoin
     */
    public function testInsertCoin(Machine $machine): Machine
    {
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(1);
        $machine->insertCoin($shortCode, $quantity);
        $coin = $machine->getCoins()[(string)$shortCode];
        $this->assertInstanceOf(Coin::class, $coin);
        $this->assertEquals(11, $coin->getQuantity()->count());
        $this->assertEquals(10, $machine->getClientBalance()->getAmount());
        $this->assertEquals(110, $machine->getTotalBalance()->getAmount());

        return $machine;
    }

    /**
     * @param Machine $machine
     *
     * @depends testInsertCoin
     */
    public function testReturnCoin(Machine $machine)
    {
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(1);
        $machine->returnCoin($shortCode, $quantity);
        $coin = $machine->getCoins()[(string)$shortCode];
        $this->assertInstanceOf(Coin::class, $coin);
        $this->assertEquals(10, $coin->getQuantity()->count());
        $this->assertEquals(0, $machine->getClientBalance()->getAmount());
        $this->assertEquals(100, $machine->getTotalBalance()->getAmount());
    }

    /**
     * @param Machine $machine
     *
     * @depends testInsertCoin
     */
    public function testCannotReturnMoreThanMachineBalance(Machine $machine)
    {
        $this->expectException(BalanceException::class);
        $this->expectExceptionMessage('Machine balance is less than expected.');
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(11);
        $machine->returnCoin($shortCode, $quantity);
    }

    /**
     * @param Machine $machine
     *
     * @depends testInsertCoin
     */
    public function testCannotReturnMoreThanClientBalance(Machine $machine)
    {
        $this->expectException(BalanceException::class);
        $this->expectExceptionMessage('Client balance is less than expected.');
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(2);
        $machine->returnCoin($shortCode, $quantity);
    }
}
