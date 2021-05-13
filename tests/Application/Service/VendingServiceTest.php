<?php
declare(strict_types=1);

namespace VendingMachine\Application\Service;

use PHPUnit\Framework\TestCase;
use VendingMachine\Application\Kernel\Kernel;
use VendingMachine\Application\Command\CreateCoin;

class VendingServiceTest extends TestCase
{
    private Kernel         $kernel;
    private VendingService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kernel  = $this->getMockForAbstractClass(Kernel::class);
        $this->service = new VendingService($this->kernel);
    }


    public function testInit()
    {
        $this->kernel
            ->expects($this->exactly(4))
            ->method('handle')
            ->with($this->isInstanceOf(CreateCoin::class));

        $this->service->init();
    }
}
