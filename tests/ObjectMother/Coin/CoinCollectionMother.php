<?php
declare(strict_types=1);

namespace VendingMachine\ObjectMother\Coin;

use VendingMachine\Domain\Coin\Service\CalculateChange;
use VendingMachine\Domain\Coin\ShortCode;
use VendingMachine\Domain\Coin\View\Coin;

class CoinCollectionMother
{
    public static function filled(): array
    {
        $coins = [];

        foreach (ShortCode::VALID_SHORTCODES as $shortCode => $amount){
            $coins[] = new Coin(
                $shortCode,
                'USD',
                $amount,
                10
            );
        }

        return $coins;
    }

    public static function withZeroQuantity(): array
    {
        $coins = [];

        foreach (ShortCode::VALID_SHORTCODES as $shortCode => $amount){
            if (in_array($shortCode, CalculateChange::RETURN_COINS)) continue;
            $coins[] = new Coin(
                $shortCode,
                'USD',
                $amount,
                0
            );
        }

        return $coins;
    }

    public static function notForReturn(): array
    {
        $coins = [];

        foreach (ShortCode::VALID_SHORTCODES as $shortCode => $amount){
            if (in_array($shortCode, CalculateChange::RETURN_COINS)) continue;
            $coins[] = new Coin(
                $shortCode,
                'USD',
                $amount,
                10
            );
        }

        return $coins;
    }
}
