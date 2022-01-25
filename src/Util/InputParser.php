<?php

declare(strict_types=1);

namespace VendingMachine\Util;

interface InputParser
{
    public function parse(string $input);
}
