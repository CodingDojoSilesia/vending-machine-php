<?php

declare(strict_types=1);

namespace Tests\Item;

use PHPUnit\Framework\TestCase;
use VendingMachine\Item\ItemA;

class ItemTest extends TestCase
{
    public function testShouldReturnValue(): void
    {
        $itemA = new ItemA();

        self::assertEquals(65, $itemA->value());
    }

    public function testShouldReturnSelector(): void
    {
        $itemA = new ItemA();

        self::assertEquals('A', $itemA->selector());
    }

    public function testShouldReturnTrueWhenItemEquals(): void
    {
        $itemA = new ItemA();

        self::assertTrue($itemA->equalsBySelector('A'));
    }
}
