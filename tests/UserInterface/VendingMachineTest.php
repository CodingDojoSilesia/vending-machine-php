<?php

declare(strict_types=1);

namespace VendingMachine\UserInterface;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use VendingMachine\Application\Service\VendingService;
use VendingMachine\Domain\Shared\Exception\BalanceException;
use VendingMachine\ObjectMother\Coin\CoinViewMother;

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

    public function testReturnCoin()
    {
        $this->service
            ->expects($this->once())
            ->method('returnCoins')
            ->willReturn([
                CoinViewMother::quarter(4),
                CoinViewMother::dime(2),
                CoinViewMother::nickel(1),
            ]);

        $this->expectOutputString('Q,Q,Q,Q,D,D,N');

        $this->vendingMachine->returnCoins();
    }

    public function testExceptionWhenReturnCoins()
    {
        $this->service
            ->method('returnCoins')
            ->willThrowException(new BalanceException('Not enough money for change.'));

        $this->expectOutputString('Not enough money for change.');

        $this->vendingMachine->returnCoins();
    }

    public function testServiceReturnsNoService(): void
    {
        $this->assertEquals('service', $this->vendingMachine->service());
    }
}
