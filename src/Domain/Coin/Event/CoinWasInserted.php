<?php

declare(strict_types=1);

namespace VendingMachine\Domain\Coin\Event;

use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;

final class CoinWasInserted
{
    private ShortCode $code;
    private Quantity  $quantity;

    private function __construct(ShortCode $code, Quantity $quantity)
    {
        $this->code     = $code;
        $this->quantity = $quantity;
    }

    public static function withData(ShortCode $code, Quantity $quantity): self
    {
        return new self($code, $quantity);
    }

    public function getShortCode(): ShortCode
    {
        return $this->code;
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }
}
