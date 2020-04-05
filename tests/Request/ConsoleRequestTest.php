<?php

declare(strict_types=1);

namespace Tests\Request;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Environment\Console;
use VendingMachine\Request\ConsoleRequest;

class ConsoleRequestTest extends TestCase
{
    public function testShouldCorrectCreateRequest(): void
    {
        self::assertInstanceOf(ConsoleRequest::class, new ConsoleRequest('GET-B'));
    }

    public function testShouldReturnAction(): void
    {
        self::assertEquals('GET-B', (new ConsoleRequest('GET-B'))->action());
    }
}
