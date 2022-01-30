<?php

declare(strict_types=1);

namespace VendingMachine\Coordinator;

use VendingMachine\Model\AvailableMoney;
use VendingMachine\Model\Money;
use VendingMachine\Model\MoneyCollection;

class PaymentCoordinator
{
    public function pay(int $input, int $cost): MoneyCollection
    {
        if ($input >= $cost) {
            $rest = $input - $cost;

            return new MoneyCollection(
                $this->calculateRest($rest, AvailableMoney::getCoins())
            );
        }
        throw new \InvalidArgumentException('No enough money to pay for it!');
    }

    /**
     * @param array<Money> $coins
     * @return array<Money>
     */
    private function calculateRest(int $rest, array $coins): array
    {
        $coinRest = [];
        /** @var Money $coin */
        foreach ($coins as $coin) {
            if ($coin->value() <= $rest) {
                $multiplication = $rest / $coin->value();
                $integerMultiplication = (int) $multiplication;

                for ($i = 0; $i < $integerMultiplication; $i++) {
                    $coinRest[] = $coin->create();
                }

                $rest -= $coin->value() * $integerMultiplication;

                if ($rest === 0) {
                    break;
                }
            }
        }

        return $coinRest;
    }
}
