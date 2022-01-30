<?php

declare(strict_types=1);

namespace VendingMachine\Model;

final class AvailableMoney
{
    public static function getMoney(): array
    {
        return [
            Nickel::create(),
            Dime::create(),
            Quarter::create(),
            Dollar::create()
        ];
    }

    public static function coins()
    {
        return [
            Nickel::create(),
            Dime::create(),
            Quarter::create(),
        ];
    }

    public static function getCoins(): array
    {
        $coins = self::coins();

        // sort DESC
        usort($coins, static function (Money $a, Money $b) {
            return ($a->value() > $b->value()) ? -1 : 1;
        });

        return $coins;
    }
}
