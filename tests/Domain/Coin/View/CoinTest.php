<?php

namespace VendingMachine\Domain\Coin\View;

use PHPUnit\Framework\TestCase;

class CoinTest extends TestCase
{
    public function testGetters()
    {
        $view = new Coin('D', 'USD', 10, 1);
        $this->assertEquals('D', $view->getShortCode());
        $this->assertEquals('USD', $view->getCurrency());
        $this->assertEquals(10, $view->getAmount());
        $this->assertEquals(1, $view->getQuantity());
    }
}
