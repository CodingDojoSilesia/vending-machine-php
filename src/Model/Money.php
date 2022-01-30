<?php

declare(strict_types=1);

namespace VendingMachine\Model;

abstract class Money
{
    protected string $shortCode = '';

    protected int $value = 0;

    public function shortCode(): string
    {
        return $this->shortCode;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function create(): Money
    {
        return new static();
    }
}
