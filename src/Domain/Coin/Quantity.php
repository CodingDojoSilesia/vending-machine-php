<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin;

use LogicException;
use InvalidArgumentException;

final class Quantity
{
    private int $value;

    private function __construct(int $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public static function fromInteger(int $value): self
    {
        return new self($value);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function add(Quantity $quantity): self
    {
        return new self($this->value + $quantity->getValue());
    }

    public function sub(Quantity $quantity): self
    {
        if (0 > $this->value - $quantity->getValue()) {
            throw new LogicException('Coin quantity must not be less than zero.');
        }

        return new self($this->value - $quantity->getValue());
    }

    private function validate(int $value): void
    {
        if (0 > $value) {
            throw new InvalidArgumentException('Coin quantity must be equal or greater than zero.');
        }
    }
}
