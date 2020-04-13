<?php

declare(strict_types=1);

namespace Tests\Model;

use PHPUnit\Framework\TestCase;
use VendingMachine\Model\MoneyCollection;
use VendingMachine\Model\Quarter;

class MoneyCollectionTest extends TestCase
{
    public function testShouldProperlySumMoney(): void
    {
        $moneyCollection = new MoneyCollection(
            [
                new Quarter(),
                new Quarter()
            ]
        );

        self::assertEquals(50, $moneyCollection->count());
    }
}
