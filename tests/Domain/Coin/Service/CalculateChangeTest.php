<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin\Service;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Coin\Exception\CoinChangeException;
use VendingMachine\Domain\Coin\Exception\CoinCountException;
use VendingMachine\Domain\Shared\Exception\BalanceException;
use VendingMachine\ObjectMother\Coin\CoinCollectionMother;
use VendingMachine\ObjectMother\Coin\CoinViewMother;

class CalculateChangeTest extends TestCase
{
    public function testNegativeBalance()
    {
        $this->expectException(BalanceException::class);
        $this->expectExceptionMessage('Not enough money for change.');
        new CalculateChange(-1, []);
    }

    public function testZeroBalance()
    {
        $this->expectException(BalanceException::class);
        $this->expectExceptionMessage('Not enough money for change.');
        new CalculateChange(0, []);
    }

    public function testEmptyCollectionCoinsForChange()
    {
        $this->expectException(CoinCountException::class);
        $this->expectExceptionMessage('Not enough coins for change.');
        new CalculateChange(100, []);
    }

    public function testOnlyInvalidReturnCoinsInCollection()
    {
        $this->expectException(CoinCountException::class);
        $this->expectExceptionMessage('Not enough coins for change.');
        new CalculateChange(100, CoinCollectionMother::withZeroQuantity());
    }

    public function testCannotChangeInvalidBalance()
    {
        $this->expectException(CoinChangeException::class);
        $this->expectExceptionMessage('There is still coins for return.');
        $calculator = new CalculateChange(123, CoinCollectionMother::filled());
        $calculator->change();
    }

    /**
     * @param int $balance
     * @param array $expectedChange
     *
     * @dataProvider changeProvider
     */
    public function testChange(int $balance, array $expectedChange)
    {
        $calculator = new CalculateChange($balance, CoinCollectionMother::filled());
        $change     = $calculator->change();
        $this->assertEquals($expectedChange, $change);
    }

    public function changeProvider(): array
    {
        return [
            [175, [CoinViewMother::quarter(7)]],
            [135, [
                CoinViewMother::quarter(5),
                CoinViewMother::dime(1)
            ]
            ],
            [90, [
                CoinViewMother::quarter(3),
                CoinViewMother::dime(1),
                CoinViewMother::nickel(1)
            ]
            ],
            [20, [CoinViewMother::dime(2)]],
            [15, [
                CoinViewMother::dime(1),
                CoinViewMother::nickel(1)
            ]
            ]
        ];
    }
}
