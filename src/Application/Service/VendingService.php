<?php

namespace VendingMachine\Application\Service;

use VendingMachine\Application\Kernel\Kernel;
use VendingMachine\Application\Coin\Command\CreateCoin;
use VendingMachine\Application\Coin\Command\InsertCoin;
use VendingMachine\Domain\Coin\ShortCode;

class VendingService
{
    private Kernel $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    public function init(): void
    {
        foreach (ShortCode::VALID_SHORTCODES as $shortCode => $amount) {
            $this->kernel->handle(CreateCoin::withData($shortCode, 10));
        }
    }

    public function insertCoin(string $shortCode, int $quantity): void
    {
        $this->kernel->handle(InsertCoin::withData($shortCode, $quantity));
    }

    public function returnCoins(): void
    {

    }
}
