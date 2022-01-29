<?php

declare(strict_types=1);

namespace Tests\Util;

use PHPUnit\Framework\TestCase;
use VendingMachine\Model\Dollar;
use VendingMachine\Model\Nickel;
use VendingMachine\Model\Quarter;
use VendingMachine\Request\ConsoleRequest;
use VendingMachine\Util\ConsoleInputParser;

class InputParserTest extends TestCase
{
    private ConsoleInputParser $parser;

    protected function setUp(): void
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

    public function testShouldReturnProductCodeFromInput(): void
    {
        $request = $this->parser->parse('Q, Q, Q, Q, GET-B');

        self::assertEquals('B', $request->productShortCode());
    }

    public function testShouldRecognizeCoinReturnAction(): void
    {
        $request = $this->parser->parse('Q, Q, Q, Q, COIN-RETURN');

        self::assertEquals('COIN-RETURN', $request->action());
    }

    /**
     * @return void
     * @dataProvider dataSetForParsingMoney
     */
    public function testShouldParseInputAndReturnConsoleRequestWithCorrectMoney(string $input, array $output): void
    {
        self::assertEquals(
            $output,
            ($this->parser->parse($input))->money()
        );
    }

    public function dataSetForParsingMoney(): array
    {
        return [
            [
                'input' => 'Q, Q, Q, Q, GET-B',
                'output' => [
                    new Quarter(),
                    new Quarter(),
                    new Quarter(),
                    new Quarter(),
                ],
            ],
            [
                'input' => 'Q,  GET-B',
                'output' => [new Quarter()]
            ],
            [
                'input' => 'N, GET-B',
                'output' => [new Nickel()]
            ]

        ];
    }
}
