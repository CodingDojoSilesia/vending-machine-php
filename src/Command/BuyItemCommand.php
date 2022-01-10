<?php

declare(strict_types=1);

namespace VendingMachine\Command;

use VendingMachine\Coordinator\PaymentCoordinator;
use VendingMachine\Repository\ItemRepository;
use VendingMachine\Request\BuyItemRequest;
use VendingMachine\Response\ConsoleResponse;

class BuyItemCommand
{
    /**
     * @var ItemRepository
     */
    private ItemRepository $itemRepository;

    /**
     * @var PaymentCoordinator
     */
    private PaymentCoordinator $paymentCoordinator;

    /**
     * @var ConsoleResponse
     */
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
            $rest = $this->paymentCoordinator->pay($moneys->count(), $availableItem->value());
            return $this->response->setRest($rest);
        }

        throw new \InvalidArgumentException('Set enough money to buy Item!');
    }
}
