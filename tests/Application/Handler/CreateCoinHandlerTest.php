<?php
declare(strict_types=1);

namespace VendingMachine\Application\Handler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Coin\Command\CreateCoin;
use VendingMachine\Domain\Coin\Exception\CoinAlreadyExist;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;
use VendingMachine\Domain\Machine\Exception\MachineNotFoundException;
use VendingMachine\Domain\Machine\Machine;
use VendingMachine\Domain\Machine\MachineRepository;

class CreateCoinHandlerTest extends TestCase
{
    /**
     * @var MachineRepository|MockObject
     */
    private MachineRepository $repository;
    private CreateCoinHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getMockForAbstractClass(MachineRepository::class);
        $this->handler    = new CreateCoinHandler($this->repository);
    }

    public function testMachineNotFound()
    {
        $this->expectException(MachineNotFoundException::class);
        $this->repository->method('findOne')->willReturn(null);
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(10);
        $this->handler->handle(CreateCoin::withData($shortCode->getCode(), $quantity->count()));
    }

    public function testCoinExist()
    {
        $this->expectException(CoinAlreadyExist::class);
        $this->expectErrorMessage('Coin with shortcode "D" already exists.');
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(10);
        $this->repository->method('findOne')->willReturn(new Machine());
        $this->handler->handle(CreateCoin::withData($shortCode->getCode(), $quantity->count()));
        $this->handler->handle(CreateCoin::withData($shortCode->getCode(), $quantity->count()));
    }

    public function testCreateCoin()
    {
        $shortCode = ShortCode::fromString('D');
        $quantity  = Quantity::fromInteger(10);
        $machine   = new Machine();
        $this->repository->method('findOne')->willReturn($machine);
        $this->repository->expects($this->once())->method('save')->with($machine);
        $this->handler->handle(CreateCoin::withData($shortCode->getCode(), $quantity->count()));
    }
}
