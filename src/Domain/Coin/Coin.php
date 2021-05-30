<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin;

final class Coin
{
    private ShortCode $code;
    private Money     $amount;
    private Quantity  $quantity;

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

    public function getShortCode(): ShortCode
    {
        return $this->code;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }

    public function increase(Quantity $quantity): void
    {
        $this->quantity = $this->quantity->add($quantity);
    }

    public function decrease(Quantity $quantity): void
    {
        $this->quantity = $this->quantity->sub($quantity);
    }
}
