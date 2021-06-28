<?php

declare(strict_types=1);

namespace VendingMachine\Application\Service;

use VendingMachine\Application\Kernel\Kernel;
use VendingMachine\Domain\Coin\Command\{
    CreateCoin,
    InsertCoin,
    ReturnCoin,
};
use VendingMachine\Domain\Coin\Service\CalculateChange;
use VendingMachine\Domain\Coin\ShortCode;
use VendingMachine\Domain\Machine\Command\CreateMachine;
use VendingMachine\Domain\Machine\Query\GetMachine;
use VendingMachine\Domain\Machine\View\Machine;

class VendingService
{
    private Kernel $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    public function init(): void
    {
        $this->kernel->handle(new CreateMachine());

        foreach (ShortCode::VALID_SHORTCODES as $shortCode => $amount) {
            $this->kernel->handle(CreateCoin::withData($shortCode, 10));
        }
    }

    public function insertCoin(string $shortCode, int $quantity): void
    {
        $this->kernel->handle(InsertCoin::withData($shortCode, $quantity));
    }

    public function returnCoins(): array
    {
        /** @var Machine $machine */
        $machine    = $this->kernel->query(new GetMachine());
        $calculator = new CalculateChange($machine->getClientBalance(), $machine->getCoins());
        $change     = $calculator->change();

        foreach ($change as $coin) {
            $this->kernel->handle(ReturnCoin::withData($coin->getShortCode(), $coin->getQuantity()));
        }

        return $change;
    }
}
