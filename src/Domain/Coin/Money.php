<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin;

use InvalidArgumentException;
use function mb_strtoupper;

/**
 * @method static Money USD(int $amount)
 */
final class Money
{
    private const  VALID_CURRENCIES = ['USD'];
    private int    $amount;
    private string $currency;

    private function __construct(int $amount, string $currency)
    {
        $this->validate($amount, $currency);
        $this->amount   = $amount;
        $this->currency = $currency;
    }

    public static function __callStatic(string $currency, array $arguments): self
    {
        return new self($arguments[0], $currency);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function add(Money $money): self
    {
        return new self($this->getAmount() + $money->getAmount(), $this->getCurrency());
    }

    public function sub(Money $money): self
    {
        if ($money->getAmount() > $this->getAmount()) {
            throw new InvalidArgumentException('The subtracted amount cannot be greater than the present amount.');
        }
        return new self($this->getAmount() - $money->getAmount(), $this->getCurrency());
    }

    private function validate(int $amount, string $currency): void
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('The value of money cannot be negative.');
        }

        if (!in_array(mb_strtoupper($currency), self::VALID_CURRENCIES, true)) {
            throw new InvalidArgumentException(sprintf('Illegal currency "%s".', $currency));
        }
    }
}
