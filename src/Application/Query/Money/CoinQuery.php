<?php
declare(strict_types=1);

namespace VendingMachine\Application\Query\Money;

use VendingMachine\Application\View\Money\CoinView;

interface CoinQuery
{
    public function getByShortCode(string $shortCode): CoinView;
    public function getAll(): array;
}
