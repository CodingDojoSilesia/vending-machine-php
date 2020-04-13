<?php

declare(strict_types=1);

namespace Tests\Command;

use PHPUnit\Framework\TestCase;
use VendingMachine\Command\BuyItemCommand;
use VendingMachine\Item\ItemB;
use VendingMachine\Model\Dollar;
use VendingMachine\Model\MoneyCollection;
use VendingMachine\Repository\InMemoryItemRepository;
use VendingMachine\Request\BuyItemRequest;
use VendingMachine\Request\ConsoleRequest;

class BuyItemCommandTest extends TestCase
{
    public function testShouldReturnBoughtBItem(): void
    {
        $itemRepository = new InMemoryItemRepository();
        $itemRepository->add(new ItemB());

        $buyItemCommand = new BuyItemCommand($itemRepository);

        $result = $buyItemCommand->execute(
            new BuyItemRequest(new ItemB(), new MoneyCollection([new Dollar()]))
        );

        self::assertTrue($result);
    }
}
