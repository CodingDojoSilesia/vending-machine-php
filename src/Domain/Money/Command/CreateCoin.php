<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Money\Command;

use VendingMachine\Domain\Money\Quantity;
use VendingMachine\Domain\Money\ShortCode;

final class CreateCoin
{
    private string $shortCode;
    private int    $quantity;

    private function __construct(string $shortCode, int $quantity)
    {
        $this->shortCode = $shortCode;
        $this->quantity  = $quantity;
    }

    public static function withData(string $shortCode, int $quantity): self
    {
        return new self($shortCode, $quantity);
    }

    public function getShortCode(): ShortCode
    {
        return ShortCode::fromString($this->shortCode);
    }

    public function getQuantity(): Quantity
    {
        return Quantity::fromInteger($this->quantity);
    }
}
