<?php
declare(strict_types=1);

namespace VendingMachine\Application\Service;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Coin\Command\InsertCoin;
use VendingMachine\Application\Kernel\Kernel;
use VendingMachine\Domain\Coin\Command\CreateCoin;
use VendingMachine\Domain\Coin\Command\ReturnCoin;
use VendingMachine\Domain\Machine\Command\CreateMachine;
use VendingMachine\Domain\Machine\Query\GetMachine;
use VendingMachine\ObjectMother\Machine\MachineViewMother;

class VendingServiceTest extends TestCase
{
    private Kernel         $kernel;
    private VendingService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kernel  = $this->getMockForAbstractClass(Kernel::class);
        $this->service = new VendingService($this->kernel);
    }

    public function testInit()
    {
        $this->kernel
            ->expects($this->exactly(5))
            ->method('handle')
            ->withConsecutive(
                [$this->isInstanceOf(CreateMachine::class)],
                [$this->isInstanceOf(CreateCoin::class)],
                [$this->isInstanceOf(CreateCoin::class)],
                [$this->isInstanceOf(CreateCoin::class)],
                [$this->isInstanceOf(CreateCoin::class)],
            );

        $this->service->init();
    }

    public function testInsertCoin()
    {
        $this->kernel
            ->expects($this->once())
            ->method('handle')
            ->with($this->isInstanceOf(InsertCoin::class));

        $this->service->insertCoin('D', 1);
    }

    public function testReturnCoins()
    {
        $this->kernel
            ->expects($this->once())
            ->method('query')
            ->with($this->isInstanceOf(GetMachine::class))
            ->willReturn(MachineViewMother::filled());

        $this->kernel
            ->expects($this->once())
            ->method('handle')
            ->with(ReturnCoin::withData('Q', 4));

        $this->service->returnCoins();
    }
}
