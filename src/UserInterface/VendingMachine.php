<?php
declare(strict_types=1);

namespace VendingMachine\UserInterface;

use Exception;
use VendingMachine\Application\Kernel\Kernel;
use VendingMachine\Domain\Money\Command\CreateCoin;
use VendingMachine\Domain\Money\Command\InsertCoin;
use VendingMachine\Domain\Money\ShortCode;

final class VendingMachine {

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

    public function insertCoin(string $shortCode): void
    {
        try {
            $this->kernel->handle(InsertCoin::withData($shortCode, 1));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function service(): string
    {
        return 'service';
    }
}
