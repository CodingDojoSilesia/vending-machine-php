<?php
declare(strict_types=1);

namespace VendingMachine\UserInterface;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use VendingMachine\Application\Kernel\Kernel;
use VendingMachine\Domain\Money\Command\CreateCoin;
use VendingMachine\Domain\Money\Command\InsertCoin;

final class VendingMachineTest extends TestCase
{
    private Kernel         $service;
    private VendingMachine $vendingMachine;

    public function setUp(): void
    {
        $this->service        = $this->getMockForAbstractClass(Kernel::class);
        $this->vendingMachine = new VendingMachine($this->service);
    }

    public function testInit()
    {
        $this->service
            ->expects($this->exactly(4))
            ->method('handle')
            ->with($this->isInstanceOf(CreateCoin::class));

        $this->vendingMachine->init();
    }

    public function testInsertCoin()
    {
        $this->service
            ->expects($this->once())
            ->method('handle')
            ->with(InsertCoin::withData('D', 1));

        $this->vendingMachine->insertCoin('D');
    }

    public function testExceptionWhenInsertCoin()
    {
        $this->expectOutputString('Illegal shortcode "E".');
        $this->service
            ->expects($this->once())
            ->method('handle')
            ->with(InsertCoin::withData('E', 1))
            ->willThrowException(new InvalidArgumentException(sprintf('Illegal shortcode "%s".', 'E')));
        $this->vendingMachine->insertCoin('E');
    }

    public function testServiceReturnsNoService(): void
    {
        $this->assertEquals('service', $this->vendingMachine->service());
    }
}
