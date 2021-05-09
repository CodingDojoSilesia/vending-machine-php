<?php
declare(strict_types=1);

namespace VendingMachine\Application\View\Money;

use IteratorAggregate;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use VendingMachine\Domain\Money\Coin;
use VendingMachine\Domain\Money\Money;

class CoinCollection implements IteratorAggregate
{
    /**
     * @var array|Coin[]
     */
    private array $money = [];
    private Money $balance;

    public function __construct()
    {
        $this->balance = Money::USD(0);
    }

    public function push(Money $money): CoinCollection
    {
        $this->money[$money->getAmount()][] = $money;
        $this->balance                      = $this->balance->add($money);

        return $this;
    }

    public function pull(int $amount): ?Coin
    {
        if (!array_key_exists($amount, $this->money) || count($this->money[$amount]) === 0) {
            return null;
        }

        $money         = array_pop($this->money[$amount]);
        $this->balance = $this->balance->sub($money);

        return $money;
    }

    public function getBalance(): Money
    {
        return $this->balance;
    }

    public function getIterator(): RecursiveIteratorIterator
    {
        return new RecursiveIteratorIterator(
            new RecursiveArrayIterator($this->money, RecursiveArrayIterator::CHILD_ARRAYS_ONLY)
        );
    }
}
