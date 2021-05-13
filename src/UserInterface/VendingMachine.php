<?php
declare(strict_types=1);

namespace VendingMachine\UserInterface;

use Exception;
use VendingMachine\Application\Service\VendingService;

final class VendingMachine {

    private VendingService $vendingService;

    public function __construct(VendingService $vendingService)
    {
        $this->vendingService = $vendingService;
    }

    public function insertCoin(string $shortCode): void
    {
        try {
            $this->vendingService->insertCoin($shortCode, 1);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function service(): string
    {
        return 'service';
    }
}
