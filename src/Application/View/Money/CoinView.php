<?php
declare(strict_types=1);

namespace VendingMachine\Application\View\Money;

class CoinView
{
    private string $shortCode;
    private string $currency;
    private int    $amount;
    private int    $quantity;

    public function __construct(string $shortCode, string $currency, int $amount, int $quantity)
    {
        $this->shortCode = $shortCode;
        $this->currency  = $currency;
        $this->amount    = $amount;
        $this->quantity  = $quantity;
    }

    public function getShortCode(): string
    {
        return $this->shortCode;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
