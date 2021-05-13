<?php
declare(strict_types=1);

namespace VendingMachine\Application\Query;

use VendingMachine\Application\Coin\View\CoinView;

interface CoinQuery
{
    public function getByShortCode(string $shortCode): CoinView;
    public function getAll(): array;
}
