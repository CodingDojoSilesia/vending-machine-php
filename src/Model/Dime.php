<?php

declare(strict_types=1);

namespace VendingMachine\Model;

class Dime extends Money implements Coin
{
    /** @var int  */
    private int $value = 25;

    public function value(): int
    {
        return $this->value;
    }
}
