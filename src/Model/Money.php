<?php

declare(strict_types=1);

namespace VendingMachine\Model;

abstract class Money
{
    public function value(): int
    {
        return $this->value;
    }
}
