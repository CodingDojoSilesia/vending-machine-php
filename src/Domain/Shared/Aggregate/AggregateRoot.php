<?php

declare(strict_types=1);

namespace VendingMachine\Domain\Shared\Aggregate;

use LogicException;
use function array_slice;
use function explode;
use function get_class;
use function implode;
use function method_exists;
use function sprintf;

abstract class AggregateRoot
{
    private array $events = [];

    protected function record(object $event): void
    {
        $this->events[] = $event;

        $this->apply($event);
    }

    protected function apply(object $event): void
    {
        $method = $this->getEventHandlerMethodFor($event);

        if (!method_exists($this, $method)) {
            throw new LogicException(sprintf('Missing event handler method %s for aggregate root %s', $method, get_class($this)));
        }

        $this->{$method}($event);
    }

    protected function getEventHandlerMethodFor(object $event): string
    {
        return 'when' . implode(array_slice(explode('\\', get_class($event)), -1));
    }
}
