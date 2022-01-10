<?php

declare(strict_types=1);

namespace Tests\Item;

use PHPUnit\Framework\TestCase;
use VendingMachine\Item\ItemA;

class ItemTest extends TestCase
{
    private ItemA $item;

    protected function setUp()
    {
        $this->item = new ItemA();
    }

    public function testShouldReturnValue(): void
    {
        self::assertEquals(65, $this->item->value());
    }

    public function testShouldReturnSelector(): void
    {
        self::assertEquals('A', $this->item->selector());
    }

    public function testShouldReturnTrueWhenItemEquals(): void
    {
        self::assertTrue($this->item->equalsBySelector('A'));
    }

    public function testShouldTestIfEnoughMoneyToBuyItem(): void
    {
        self::assertFalse($this->item->enoughToBuy(10));
    }
}
