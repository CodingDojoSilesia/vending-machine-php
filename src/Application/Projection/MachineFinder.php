<?php

declare(strict_types=1);

namespace VendingMachine\Application\Projection;

use VendingMachine\Domain\Machine\View\Machine;

interface MachineFinder
{
    public function findOne(): Machine;
}
