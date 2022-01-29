<?php declare(strict_types=1);

namespace Tests\Command;

use PHPUnit\Framework\TestCase;
use VendingMachine\Command\CoinReturnCommand;
use VendingMachine\Model\Dime;
use VendingMachine\Model\Dollar;
use VendingMachine\Model\MoneyCollection;
use VendingMachine\Request\CoinReturnRequest;

class CoinReturnCommandTest extends TestCase
{
    public function testShouldReturnInsertedCoinsInRest(): void
    {
        $moneyCollection = new MoneyCollection([new Dime(), new Dollar()]);

        $command = new CoinReturnCommand();

        $result = $command->execute(new CoinReturnRequest($moneyCollection));

        self::assertEquals(new MoneyCollection([new Dime(), new Dollar()]), $result->rest());
    }
}