<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin\Command;

use VendingMachine\Domain\Shared\Command\CommandInterface;

final class ReturnCoin implements CommandInterface
{
    private string $shortCode;
    private int  $quantity;

    private function __construct(string $shortCode, int $quantity)
    {
        $this->shortCode = $shortCode;
        $this->quantity  = $quantity;
    }

    public static function withData(string $shortCode, int $quantity): self
    {
        return new self($shortCode, $quantity);
    }

    public function getShortCode(): string
    {
        return $this->shortCode;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
