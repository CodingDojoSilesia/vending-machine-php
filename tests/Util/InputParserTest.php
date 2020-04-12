<?php

declare(strict_types=1);

namespace Tests\Util;

use PHPUnit\Framework\TestCase;
use VendingMachine\Model\Quarter;
use VendingMachine\Request\ConsoleRequest;
use VendingMachine\Util\ConsoleInputParser;

class InputParserTest extends TestCase
{
    /**
     * @var ConsoleInputParser
     */
    private ConsoleInputParser $parser;

    protected function setUp()
    {
        $this->parser = new ConsoleInputParser();
    }
    
    public function testShouldParseBuyItemInputAndReturnConsoleRequest(): void
    {
        $request = $this->parser->parse('Q, Q, Q, Q, GET-B');

        self::assertInstanceOf(ConsoleRequest::class, $request);
    }

    public function testShouldParseInputAndReturnConsoleRequestWithActionGet(): void
    {
        $request = $this->parser->parse('Q, Q, Q, Q, GET-B');

        self::assertEquals('GET-B', $request->action());
    }

    public function testShouldParseInputAndReturnConsoleRequestWith4QuarterMoney(): void
    {
        $request = $this->parser->parse('Q, Q, Q, Q, GET-B');


        self::assertEquals(
            [
                new Quarter(),
                new Quarter(),
                new Quarter(),
                new Quarter(),
            ],
            $request->money()
        );
    }
}
