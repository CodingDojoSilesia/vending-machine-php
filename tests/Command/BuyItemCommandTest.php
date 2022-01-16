<?php

declare(strict_types=1);

namespace Tests\Command;

use PHPUnit\Framework\TestCase;
use VendingMachine\Command\BuyItemCommand;
use VendingMachine\Coordinator\PaymentCoordinator;
use VendingMachine\Item\ItemB;
use VendingMachine\Model\Dollar;
use VendingMachine\Model\MoneyCollection;
use VendingMachine\Repository\InMemoryItemRepository;
use VendingMachine\Request\BuyItemRequest;
use VendingMachine\Response\ConsoleResponse;

class BuyItemCommandTest extends TestCase
{
    public function testShouldReturnBoughtBItem(): void
    {
        $itemRepository = new InMemoryItemRepository();
        $itemRepository->add(new ItemB());

        $buyItemCommand = new BuyItemCommand($itemRepository, new PaymentCoordinator(), new ConsoleResponse());

        $result = $buyItemCommand->execute(
            new BuyItemRequest(new ItemB(), new MoneyCollection([new Dollar()]))
        );

        self::assertInstanceOf(ConsoleResponse::class, $result);
    }

    public function testShouldCalculateRestAndReturnResponseWithCorrectAmount(): void
    {
        $itemRepository = new InMemoryItemRepository();
        $itemRepository->add(new ItemB());

        $buyItemCommand = new BuyItemCommand($itemRepository, new PaymentCoordinator(), new ConsoleResponse());

        $result = $buyItemCommand->execute(
            new BuyItemRequest(new ItemB(), new MoneyCollection([new Dollar()]))
        );

        self::assertEquals(35, $result->rest()->count());
    }
}
