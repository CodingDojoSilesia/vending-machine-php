<?php

declare(strict_types=1);

namespace VendingMachine;

use VendingMachine\Command\BuyItemCommand;
use VendingMachine\Command\CoinReturnCommand;
use VendingMachine\Coordinator\PaymentCoordinator;
use VendingMachine\Item\ItemsInSale;
use VendingMachine\Repository\ItemRepository;
use VendingMachine\Request\BuyItemRequest;
use VendingMachine\Request\CoinReturnRequest;
use VendingMachine\Request\ConsoleRequest;
use VendingMachine\Response\ConsoleResponse;
use VendingMachine\Response\Response;
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

    public function execute(string $input): Response
    {
        $request = $this->parseInput($input);


        if (preg_match("/GET-[" . implode('|', ItemsInSale::itemShortCodes()). "]/", $input)) {
            return $this->executeBuy($request);
        }

        if (str_contains($input, 'COIN-RETURN')) {
            return $this->executeCoinReturn($request);
        }

        throw new \RuntimeException('Vending machine has error. Try again, please.');
    }

    private function parseInput(string $input): ConsoleRequest
    {
        return $this->inputParser->parse($input);
    }

    private function executeBuy(ConsoleRequest $request): Response
    {
        $buyCommand = new BuyItemCommand($this->itemRepository, new PaymentCoordinator(), new ConsoleResponse());
        // get item from input and parse it
        return $buyCommand->execute(
            new BuyItemRequest($request->productShortCode(), $request->moneyCollection())
        );
    }

    private function executeCoinReturn(ConsoleRequest $request): Response
    {
        return (new CoinReturnCommand())->execute(
            new CoinReturnRequest($request->moneyCollection())
        );
    }
}
