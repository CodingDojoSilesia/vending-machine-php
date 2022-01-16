<?php

declare(strict_types=1);

namespace VendingMachine\Command;

use VendingMachine\Coordinator\PaymentCoordinator;
use VendingMachine\Repository\ItemRepository;
use VendingMachine\Request\BuyItemRequest;
use VendingMachine\Response\ConsoleResponse;

class BuyItemCommand
{
    private ItemRepository $itemRepository;

    private PaymentCoordinator $paymentCoordinator;

    private ConsoleResponse $response;

    public function __construct(
        ItemRepository $itemRepository,
        PaymentCoordinator $paymentCoordinator,
        ConsoleResponse $response
    ) {
        $this->itemRepository = $itemRepository;
        $this->paymentCoordinator = $paymentCoordinator;
        $this->response = $response;
    }

    public function execute(BuyItemRequest $request): ConsoleResponse
    {
        $item = $request->item();
        $moneys = $request->moneyCollection();

        $availableItem = $this->itemRepository->getItemBySelector($item->selector());

        if ($availableItem === null) {
            throw new \InvalidArgumentException(sprintf('Item %s is not available', $item->selector()));
        }

        if ($item->enoughToBuy($moneys->count())) {
            return $this->response->setRest(
                $this->paymentCoordinator->pay($moneys->count(), $availableItem->value())
            );
        }

        throw new \InvalidArgumentException('Set enough money to buy Item!');
    }
}
