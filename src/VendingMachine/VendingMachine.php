<?php

declare(strict_types=1);

namespace VendingMachine;

final class VendingMachine {
    function __construct() {}

    public function service(): string
    {
        return 'no service';
    }
}
