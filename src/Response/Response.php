<?php declare(strict_types=1);

namespace VendingMachine\Response;

interface Response
{
    public function getOutput(): string;
}
