<?php

declare(strict_types=1);

namespace VendingMachine\Request;

use VendingMachine\Model\MoneyCollection;

class BuyItemRequest implements CommandRequest
{
    public function __construct(private string $item, private MoneyCollection $moneyCollection)
    {
    }

    public function moneyCollection(): MoneyCollection
    {
        return $this->moneyCollection;
    }

    public function item(): string
    {
        return $this->item;
    }
}
