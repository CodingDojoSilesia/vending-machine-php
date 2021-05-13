<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin;

interface CoinRepository
{
    public function findByShortCode(ShortCode $code): ?Coin;
    public function save(Coin $coin);
}
