<?php

declare(strict_types=1);

namespace VendingMachine\Model;

abstract class Money implements MoneyCreationInterface
{
    protected const SHORT_CODE = '';

    protected const VALUE = 0;

    public function __construct(protected string $shortCode, protected int $value)
    {
    }

    public function shortCode(): string
    {
        return $this->shortCode;
    }

    public function value(): int
    {
        return $this->value;
    }
}
