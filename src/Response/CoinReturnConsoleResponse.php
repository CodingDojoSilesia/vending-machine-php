<?php

declare(strict_types=1);

namespace VendingMachine\Response;

use VendingMachine\Model\Money;
use VendingMachine\Model\MoneyCollection;

class CoinReturnConsoleResponse extends Response
{
    public function __construct(private MoneyCollection $moneyCollection)
    {
    }

    public function result(): MoneyCollection
    {
        return $this->moneyCollection;
    }

    public function __toString()
    {
        return implode(
            ', ',
            array: array_map(static fn(Money $money) => $money->shortCode(), $this->moneyCollection->money())
        );
    }
}
