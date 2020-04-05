<?php

namespace VendingMachine\Command;

interface Command
{
    public function execute(): void;
}
