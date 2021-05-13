<?php
declare(strict_types=1);

namespace VendingMachine\Application\View;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Coin\Coin;
use VendingMachine\Domain\Coin\Quantity;
use VendingMachine\Domain\Coin\ShortCode;

class CoinCollectionTest extends TestCase
{
    private CoinCollection $collection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->collection = new CoinCollection();
    }

    public function testInstance()
    {
        $this->assertInstanceOf(CoinCollection::class, $this->collection);
    }

    public function testAppend()
    {
        $this->collection->append(Coin::withData(ShortCode::fromString('DOL'), Quantity::fromInteger(1)));
        $this->collection->append(Coin::withData(ShortCode::fromString('Q'), Quantity::fromInteger(1)));
        $this->collection->append(Coin::withData(ShortCode::fromString('D'), Quantity::fromInteger(1)));
        $this->collection->append(Coin::withData(ShortCode::fromString('N'), Quantity::fromInteger(1)));

        $this->assertCount(4, $this->collection);
    }
}
