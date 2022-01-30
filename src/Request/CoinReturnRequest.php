<?php

declare(strict_types=1);

namespace VendingMachine\Request;

use VendingMachine\Model\MoneyCollection;

class CoinReturnRequest implements CommandRequest
{
    public function __construct(private MoneyCollection $moneyCollection)
    {
    }

    public function moneyCollection(): MoneyCollection
    {
        return $this->moneyCollection;
    }
}
