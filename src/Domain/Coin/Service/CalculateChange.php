<?php

declare(strict_types=1);

namespace VendingMachine\Domain\Coin\Service;

use VendingMachine\Domain\Coin\Exception\CoinChangeException;
use VendingMachine\Domain\Coin\Exception\CoinCountException;
use VendingMachine\Domain\Coin\View\Coin;
use VendingMachine\Domain\Shared\Exception\BalanceException;

use function array_filter;
use function in_array;
use function count;
use function usort;

final class CalculateChange
{
    public const RETURN_COINS = ['D', 'Q', 'N'];
    private int   $balance;
    private array $coins;

    public function __construct(int $balance, array $coins)
    {
        if ($balance <= 0) {
            throw new BalanceException('Not enough money for change.');
        }

        /** @var Coin[] $coins */
        $coins = array_filter(
            $coins,
            fn($coin): bool => in_array($coin->getShortCode(), self::RETURN_COINS) && $coin->getQuantity() > 0
        );

        if (!count($coins)) {
            throw new CoinCountException('Not enough coins for change.');
        }

        $this->balance = $balance;
        $this->coins   = $coins;
    }

    /**
     * @return Coin[]
     */
    public function change(): array
    {
        $returnCoins = [];

        usort($this->coins, fn(Coin $current, Coin $next) => $next->getAmount() <=> $current->getAmount());

        foreach ($this->coins as $coin) {
            for ($i=0; $i<$coin->getQuantity(); $i++) {
                if ($this->balance < $coin->getAmount()) break;
                $this->balance -= $coin->getAmount();
            }

            $returnCoins[] = new Coin($coin->getShortCode(), $coin->getCurrency(), $coin->getAmount(), $i);
        }

        if ($this->balance > 0) {
            throw new CoinChangeException('There is still coins for return.');
        }

        return array_values(array_filter($returnCoins, fn(Coin $coin): bool => $coin->getQuantity() > 0));
    }
}
