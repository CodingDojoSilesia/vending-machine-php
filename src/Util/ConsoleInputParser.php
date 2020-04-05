<?php

declare(strict_types=1);

namespace VendingMachine\Util;

class ConsoleInputParser implements InputParser
{
    public function parse(string $input): array
    {
        $request = explode(',', $input);

        return array_map(static function($element) {
            return trim($element);
        }, $request);

        // parse to request
    }
}
