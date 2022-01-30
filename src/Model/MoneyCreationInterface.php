<?php

declare(strict_types=1);

namespace VendingMachine\Model;

interface MoneyCreationInterface
{
    public static function create(): Money;
}