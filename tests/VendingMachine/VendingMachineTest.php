<?php

declare(strict_types=1);

namespace Tests\VendingMachine;

use VendingMachine\VendingMachine;
use PHPUnit\Framework\TestCase;

final class VendingMachineTest extends TestCase
{
    /** @var VendingMachine */
    private $vendingMachine;

    public function setUp(): void
    {
        $this->vendingMachine = new VendingMachine();
    }

    public function testServiceReturnsNoService(): void
    {
        $this->assertEquals('test', $this->vendingMachine->execute('test'));
    }
}
