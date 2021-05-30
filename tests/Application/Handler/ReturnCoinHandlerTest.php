<?php
declare(strict_types=1);

namespace VendingMachine\Application\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Coin\Command\CreateCoin;
use VendingMachine\Domain\Coin\Command\InsertCoin;
use VendingMachine\Domain\Coin\Command\ReturnCoin;
use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Domain\Coin\Exception\CoinNotFoundException;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;
use VendingMachine\Domain\Machine\Exception\MachineNotFoundException;
use VendingMachine\Domain\Machine\Machine;
use VendingMachine\Domain\Machine\MachineRepository;

class ReturnCoinHandlerTest extends TestCase
{
    /**
     * @var MachineRepository|MockObject
     */
    private MachineRepository $repository;
    private ReturnCoinHandler $returnCoinHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository        = $this->getMockForAbstractClass(MachineRepository::class);
        $this->returnCoinHandler = new ReturnCoinHandler($this->repository);
    }

    public function testMachineNotFound()
    {
        $this->expectException(MachineNotFoundException::class);
        $this->repository->method('findOne')->willReturn(null);
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(10);
        $this->returnCoinHandler->handle(ReturnCoin::withData($shortCode->getCode(), $quantity->count()));
    }

    public function testCoinNotExists()
    {
        $this->expectException(CoinNotFoundException::class);
        $this->expectErrorMessage('Coin with shortcode "D" cannot be found.');
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(10);
        $this->repository->method('findOne')->willReturn(new Machine());
        $this->returnCoinHandler->handle(ReturnCoin::withData($shortCode->getCode(), $quantity->count()));
    }

    public function testReturnCoin()
    {
        $createCoinHandler = new CreateCoinHandler($this->repository);
        $insertCoinHandler = new InsertCoinHandler($this->repository);
        $machine           = new Machine();
        $shortCode         = ShortCode::fromString('D');
        $quantity          = Quantity::fromInteger(10);
        $this->repository->method('findOne')->willReturn($machine);
        $this->repository->expects($this->exactly(3))->method('save')->with($machine);
        $createCoinHandler->handle(CreateCoin::withData($shortCode->getCode(), $quantity->count()));
        $insertCoinHandler->handle(InsertCoin::withData($shortCode->getCode(), 5));
        $this->returnCoinHandler->handle(ReturnCoin::withData($shortCode->getCode(), 3));

        $this->assertCount(1, $machine->getCoins());
        $this->assertArrayHasKey((string)$shortCode, $machine->getCoins());
        $coin = $machine->getCoins()[(string)$shortCode];
        $this->assertInstanceOf(Coin::class, $coin);
        $this->assertEquals(12, $coin->getQuantity()->count());
    }
}
