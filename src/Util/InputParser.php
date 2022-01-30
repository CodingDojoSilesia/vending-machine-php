<?php

declare(strict_types=1);

namespace VendingMachine\Util;

use VendingMachine\Request\ConsoleRequest;

interface InputParser
{
    public function parse(string $input): ConsoleRequest;
}
