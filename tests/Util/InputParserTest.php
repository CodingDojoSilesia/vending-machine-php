<?php

declare(strict_types=1);

namespace Tests\Util;

use PHPUnit\Framework\TestCase;
use VendingMachine\Util\ConsoleInputParser;

class InputParserTest extends TestCase
{
    public function testShouldParseBuyItemInput(): void
    {
        $parser = new ConsoleInputParser();
        $request = $parser->parse('Q, Q, Q, Q, GET-B');

        // ? class BuyRequest ?
    }
}
