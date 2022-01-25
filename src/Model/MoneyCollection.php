<?php

declare(strict_types=1);

namespace VendingMachine\Model;

class MoneyCollection implements \Countable
{
    /** @var array|Money[] */
    private array $money = [];

    public function __construct(array $moneys)
    {
        foreach ($moneys as $money) {
            $this->addMoney($money);
        }
    }

    public function addMoney(Money $money): void
    {
        $this->money[] = $money;
    }

    public function money()
    {
        return $this->money;
    }

    public function count(): int
    {
        $sum = 0;

        foreach ($this->money as $money) {
            $sum += $money->value();
        }

        return $sum;
    }
}
