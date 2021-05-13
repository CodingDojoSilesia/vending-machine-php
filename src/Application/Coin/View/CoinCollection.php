<?php
declare(strict_types=1);

namespace VendingMachine\Application\Coin\View;

use IteratorAggregate;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use VendingMachine\Domain\Coin\Money;

class CoinCollection implements IteratorAggregate
{
    /**
     * @var array|CoinView[]
     */
    private array $coins = [];
    private Money $balance;

    public function __construct()
    {
        $this->balance = Money::USD(0);
    }

    public function push(CoinView $coin): CoinCollection
    {
        $this->coins[$coin->getShortCode()][] = $coin;
        $this->balance                     = $this->balance->add($coin);

        return $this;
    }

    public function pull(int $amount): ?CoinView
    {
        if (!array_key_exists($amount, $this->coins) || count($this->coins[$amount]) === 0) {
            return null;
        }

        $money         = array_pop($this->coins[$amount]);
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
            new RecursiveArrayIterator($this->coins, RecursiveArrayIterator::CHILD_ARRAYS_ONLY)
        );
    }
}
