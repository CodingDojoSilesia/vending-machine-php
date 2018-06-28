<?php

declare(strict_types=1);

namespace VendingMachine;

use PHPUnit\Framework\TestCase;

final class VendingMachineTest extends TestCase
{
    /**
     * @var VendingMachine
     */
    private $vendingMachine;

    public function setUp(): void
    {
        $vm = new VendingMachine();
        $this->vendingMachine = $vm;
    }

    public function testServiceReturnsNoService(): void
    {
        $this->assertEquals('service', $this->vendingMachine->service());
    }
}
