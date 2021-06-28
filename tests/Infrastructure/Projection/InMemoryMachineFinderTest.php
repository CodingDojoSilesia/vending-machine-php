<?php

declare(strict_types=1);

namespace VendingMachine\Infrastructure\Projection;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Machine\Exception\MachineNotFoundException;
use VendingMachine\Domain\Machine\View\Machine;
use VendingMachine\Domain\Machine\MachineRepository;
use VendingMachine\ObjectMother\Machine\MachineMother;

class InMemoryMachineFinderTest extends TestCase
{
    private InMemoryMachineFinder $finder;
    private MachineRepository     $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getMockForAbstractClass(MachineRepository::class);
        $this->finder     = new InMemoryMachineFinder($this->repository);
    }

    public function testMachineNotFound()
    {
        $this->expectException(MachineNotFoundException::class);
        $this->repository->method('findOne')->willReturn(null);
        $this->finder->findOne();
    }

    public function testFindMachine()
    {
        $this->repository->method('findOne')->willReturn(MachineMother::filled());
        $machine = $this->finder->findOne();
        $this->assertInstanceOf(Machine::class, $machine);
        $this->assertEquals(1540, $machine->getTotalBalance());
        $this->assertEquals(140, $machine->getClientBalance());
        $this->assertCount(4, $machine->getCoins());
    }
}
