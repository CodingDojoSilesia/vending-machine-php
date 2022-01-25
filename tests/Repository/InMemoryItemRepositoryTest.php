<?php

declare(strict_types=1);

namespace Tests\Repository;

use PHPUnit\Framework\TestCase;
use VendingMachine\Item\ItemA;
use VendingMachine\Item\ItemB;
use VendingMachine\Item\ItemC;
use VendingMachine\Repository\InMemoryItemRepository;

class InMemoryItemRepositoryTest extends TestCase
{
    public function testShouldAddToRepositoryItem(): void
    {
        $repository = new InMemoryItemRepository();
        $repository->add(new ItemA());

        self::assertEquals([new ItemA()], $repository->getAll());
    }

    public function testShouldReturnItemBySelector(): void
    {
        $repository = new InMemoryItemRepository();
        $repository->add(new ItemA());
        $repository->add(new ItemB());
        $repository->add(new ItemC());

        $itemBselector = (new ItemB())->selector();

        $result = $repository->getItemBySelector((new ItemB())->selector());

        self::assertEquals(new ItemB(), $result);
    }
}
