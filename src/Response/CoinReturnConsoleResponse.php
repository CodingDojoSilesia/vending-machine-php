<?php declare(strict_types=1);

namespace VendingMachine\Response;

use VendingMachine\Model\Money;
use VendingMachine\Model\MoneyCollection;

class CoinReturnConsoleResponse implements Response
{
    public function __construct(private MoneyCollection $moneyCollection)
    {
    }

    public function getOutput(): string
    {
        return implode(
            ', ',
            array: array_map(static fn(Money $money) => $money->shortCode(), $this->moneyCollection->money())
        );
    }
}