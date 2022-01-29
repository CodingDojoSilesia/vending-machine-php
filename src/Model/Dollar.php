<?php

declare(strict_types=1);

namespace VendingMachine\Model;

final class Dollar extends Money implements PaperMoney
{
    protected string $shortCode = 'DOLLAR';

    protected int $value = 100;
}
