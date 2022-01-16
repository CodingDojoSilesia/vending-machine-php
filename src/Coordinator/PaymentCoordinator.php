<?php

declare(strict_types=1);

namespace VendingMachine\Coordinator;

use VendingMachine\Model\AvailableMoney;
use VendingMachine\Model\Coin;
use VendingMachine\Model\Money;
use VendingMachine\Model\MoneyCollection;

class PaymentCoordinator
{
    public function pay(int $input, int $cost): MoneyCollection
    {
        if ($input >= $cost) {
            $rest = $input - $cost;
            $coinRest = $this->calculateRest($rest, $this->getCoins());
            return new MoneyCollection($coinRest);
        }
        // add domain exception with information about passed values
        throw new \InvalidArgumentException('No enough money to pay for it!');
    }

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

    private function getCoins(): array
    {
        $coins = array_filter(AvailableMoney::getMoney(), static function(Money $money) {
            return $money instanceof Coin;
        });
        // sort DESC
        usort($coins, static function(Money $a, Money $b) {
            return $a->value() < $b->value();
        });

        return $coins;
    }

}
