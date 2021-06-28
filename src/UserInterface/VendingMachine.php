<?php

declare(strict_types=1);

namespace VendingMachine\UserInterface;

use Exception;
use VendingMachine\Application\Service\VendingService;
use VendingMachine\Domain\Coin\View\Coin;

/**
 * @todo Add Response, catch exceptions in handler
 */
final class VendingMachine {

    public function __construct(private VendingService $vendingService){}

    public function insertCoin(string $shortCode): void
    {
        try {
            $this->vendingService->insertCoin($shortCode, 1);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function returnCoins(): void
    {
        try {
            $coins = $this->vendingService->returnCoins();

            echo implode(',', array_map(fn(Coin $coin): string =>
                implode(',', array_fill(0, $coin->getQuantity(), $coin->getShortCode())),
                $coins
            ));

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function service(): string
    {
        return 'service';
    }
}
