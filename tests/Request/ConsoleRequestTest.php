<?php

declare(strict_types=1);

namespace Tests\Request;

use PHPUnit\Framework\TestCase;
use VendingMachine\Model\Dime;
use VendingMachine\Request\ConsoleRequest;

class ConsoleRequestTest extends TestCase
{
    public function testShouldCorrectCreateRequest(): void
    {
        self::assertInstanceOf(ConsoleRequest::class, new ConsoleRequest('GET-B'));
    }

    /**
     * @dataProvider dataTestToParseAction
     */
    public function testShouldReturnAction($input, $output): void
    {
        self::assertEquals($input, (new ConsoleRequest($output))->action());
    }

    public function dataTestToParseAction(): array
    {
        return [
            ['GET-B', 'GET-B'],
        ];
    }

    public function testShouldThrowInvalidArgumentExceptionWhenActionNameIsInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new ConsoleRequest('test');
    }

    public function testShouldAddMoneyToRequest(): void
    {
        $consoleRequest = new ConsoleRequest('GET-B');
        $consoleRequest->addMoney(new Dime());

        self::assertEquals([new Dime()], $consoleRequest->money());
    }
}
