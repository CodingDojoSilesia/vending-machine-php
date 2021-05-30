<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Machine\View;

class Machine
{
    public function __construct(private int $totalBalance, private int $clientBalance, private array $coins){}

    public function getTotalBalance(): int
    {
        return $this->totalBalance;
    }

    public function getClientBalance(): int
    {
        return $this->clientBalance;
    }

    public function getCoins(): array
    {
        return $this->coins;
    }
}
