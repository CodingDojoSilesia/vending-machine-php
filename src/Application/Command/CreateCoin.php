<?php
declare(strict_types=1);

namespace VendingMachine\Application\Coin\Command;

use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;

final class CreateCoin
{
    private ShortCode $shortCode;
    private Quantity  $quantity;

    private function __construct(ShortCode $shortCode, Quantity $quantity)
    {
        $this->shortCode = $shortCode;
        $this->quantity  = $quantity;
    }

    public static function withData(string $shortCode, int $quantity): self
    {
        return new self(ShortCode::fromString($shortCode), Quantity::fromInteger($quantity));
    }

    public function getShortCode(): ShortCode
    {
        return $this->shortCode;
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }
}
