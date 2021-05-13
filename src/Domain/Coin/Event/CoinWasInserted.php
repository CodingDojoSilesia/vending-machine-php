<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin\Event;

use VendingMachine\Domain\Coin\Money;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;

final class CoinWasInserted
{
    private Money     $amount;
    private Quantity  $quantity;
    private ShortCode $code;

    private function __construct(ShortCode $code, Money $amount, Quantity $quantity)
    {
        $this->code     = $code;
        $this->amount   = $amount;
        $this->quantity = $quantity;
    }

    public static function withData(ShortCode $code, Money $amount, Quantity $quantity): self
    {
        return new self($code, $amount, $quantity);
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }

    public function getCode(): ShortCode
    {
        return $this->code;
    }
}
