<?php
declare(strict_types=1);

namespace VendingMachine\Application\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Coin\Command\CreateCoin;
use VendingMachine\Domain\Coin\Command\InsertCoin;
use VendingMachine\Domain\Coin\Exception\CoinNotFoundException;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;
use VendingMachine\Domain\Machine\Exception\MachineNotFoundException;
use VendingMachine\Domain\Machine\Machine;
use VendingMachine\Domain\Machine\MachineRepository;

class InsertCoinHandlerTest extends TestCase
{
    /**
     * @var MachineRepository|MockObject
     */
    private MachineRepository $repository;
    private InsertCoinHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getMockForAbstractClass(MachineRepository::class);
        $this->handler    = new InsertCoinHandler($this->repository);
    }

    public function testMachineNotFound()
    {
        $this->expectException(MachineNotFoundException::class);
        $this->repository->method('findOne')->willReturn(null);
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(10);
        $this->handler->handle(InsertCoin::withData($shortCode->getCode(), $quantity->count()));
    }

    public function testCoinNotExists()
    {
        $this->expectException(CoinNotFoundException::class);
        $this->expectErrorMessage('Coin with shortcode "D" cannot be found.');
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(10);
        $this->repository->method('findOne')->willReturn(new Machine());
        $this->handler->handle(InsertCoin::withData($shortCode->getCode(), $quantity->count()));
    }

    public function testInsertCoin()
    {
        $shortCode = ShortCode::fromString('D');
        $machine   = new Machine();
        $this->repository->method('findOne')->willReturn($machine);
        $this->repository->expects($this->exactly(2))->method('save')->with($machine);
        $createCoinHandler = new CreateCoinHandler($this->repository);
        $createCoinHandler->handle(CreateCoin::withData($shortCode->getCode(), 1));
        $this->handler->handle(InsertCoin::withData($shortCode->getCode(), 1));
    }
}
