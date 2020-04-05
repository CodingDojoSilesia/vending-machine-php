<?php

declare(strict_types=1);

namespace VendingMachine\Model;

interface Coin
{
    public function value(): int;
}
