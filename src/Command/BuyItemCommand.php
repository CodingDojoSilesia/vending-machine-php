<?php

declare(strict_types=1);

namespace VendingMachine\Command;

use VendingMachine\Coordinator\PaymentCoordinator;
use VendingMachine\Repository\ItemRepository;
use VendingMachine\Request\BuyItemRequest;
use VendingMachine\Response\ConsoleResponse;

class BuyItemCommand
{
    public function __construct(
        private ItemRepository $itemRepository,
        private PaymentCoordinator $paymentCoordinator,
        private ConsoleResponse $response
    ) {
    }

    public function execute(BuyItemRequest $request): ConsoleResponse
    {
        $item = $request->item();
        $moneys = $request->moneyCollection();

        $availableItem = $this->itemRepository->getItemBySelector($item);

        if (!$availableItem) {
            throw new \InvalidArgumentException(sprintf('Item %s is not available', $item));
        }

        if ($availableItem->enoughToBuy($moneys->count())) {
            $this->response->setProduct($availableItem);

            return $this->response->setRest(
                $this->paymentCoordinator->pay($moneys->count(), $availableItem->value())
            );
        }

        throw new \InvalidArgumentException('Set enough money to buy Item!');
    }
}
