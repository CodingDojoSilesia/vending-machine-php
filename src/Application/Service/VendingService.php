<?php

namespace VendingMachine\Application\Service;

use VendingMachine\Application\Kernel\Kernel;

class VendingService
{
    private Kernel $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }
}
