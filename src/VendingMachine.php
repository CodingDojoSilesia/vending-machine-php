<?php

declare(strict_types=1);

namespace VendingMachine;

use VendingMachine\Command\BuyItemCommand;
use VendingMachine\Coordinator\PaymentCoordinator;
use VendingMachine\Item\ItemB;
use VendingMachine\Repository\ItemRepository;
use VendingMachine\Request\BuyItemRequest;
use VendingMachine\Request\ConsoleRequest;
use VendingMachine\Response\ConsoleResponse;
use VendingMachine\Util\InputParser;

final class VendingMachine
{
    private ItemRepository $itemRepository;

    private InputParser $inputParser;

    public function __construct(ItemRepository $itemRepository, InputParser $inputParser)
    {
        $this->itemRepository = $itemRepository;
        $this->inputParser = $inputParser;
    }

    public function execute(string $input): ConsoleResponse
    {
        $request = $this->parseInput($input);

        $buyCommand = new BuyItemCommand($this->itemRepository, new PaymentCoordinator(), new ConsoleResponse());

        return $buyCommand->execute(
            new BuyItemRequest(new ItemB(), $request->moneyCollection())
        );
    }

    private function parseInput(string $input): ConsoleRequest
    {
        return $this->inputParser->parse($input);
    }
}
