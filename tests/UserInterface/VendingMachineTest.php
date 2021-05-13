<?php
declare(strict_types=1);

namespace VendingMachine\UserInterface;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use VendingMachine\Application\Service\VendingService;

final class VendingMachineTest extends TestCase
{
    private VendingService $service;
    private VendingMachine $vendingMachine;

    public function setUp(): void
    {
        $this->service        = $this->getMockBuilder(VendingService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->vendingMachine = new VendingMachine($this->service);
    }

    public function testInsertCoin()
    {
        $this->service
            ->expects($this->once())
            ->method('insertCoin')
            ->with('D', 1);

        $this->vendingMachine->insertCoin('D');
    }

    public function testExceptionWhenInsertCoin()
    {
        $this->expectOutputString('Illegal shortcode "E".');
        $this->service
            ->expects($this->once())
            ->method('insertCoin')
            ->with('E', 1)
            ->willThrowException(new InvalidArgumentException(sprintf('Illegal shortcode "%s".', 'E')));
        $this->vendingMachine->insertCoin('E');
    }

    public function testServiceReturnsNoService(): void
    {
        $this->assertEquals('service', $this->vendingMachine->service());
    }
}
