<?php



namespace VendingMachine\Item;

abstract class Item
{
    protected string $selector = '';

    protected int $value = 0;

    public function value(): int
    {
        return $this->value;
    }

    public function selector(): string
    {
        return $this->selector;
    }

    public function equalsBySelector(string $selector): bool
    {
        return $this->selector === $selector;
    }

    public function enoughToBuy(int $count): bool
    {
        return $count >= $this->value;
    }
}
