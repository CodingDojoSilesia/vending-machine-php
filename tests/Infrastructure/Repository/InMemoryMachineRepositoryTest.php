<?php

declare(strict_types=1);

namespace VendingMachine\Infrastructure\Repository;

use PHPUnit\Framework\TestCase;
use VendingMachine\Domain\Machine\Machine;

class InMemoryMachineRepositoryTest extends TestCase
{
    private InMemoryMachineRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new InMemoryMachineRepository();
    }

    public function testEmptyRepository()
    {
        $this->assertNull($this->repository->findOne());
    }

    public function testFindMachine()
    {
        $this->repository->save(new Machine());
        $this->assertInstanceOf(Machine::class, $this->repository->findOne());
    }
}
