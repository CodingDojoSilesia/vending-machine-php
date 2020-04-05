<?php

declare(strict_types=1);

namespace VendingMachine\Model;

class Dime implements Coin
{
    /** @var int  */
    private int $value = 25;

    public function value(): Value
    {
        return $this->value;
    }
}
