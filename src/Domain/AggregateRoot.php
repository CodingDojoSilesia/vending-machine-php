<?php
declare(strict_types=1);

namespace VendingMachine\Domain;

abstract class AggregateRoot
{
    private array $events = [];

    protected function record(object $event): void
    {
        $this->events[] = $event;

        $this->apply($event);
    }

    abstract protected function apply(object $event): void;
}
