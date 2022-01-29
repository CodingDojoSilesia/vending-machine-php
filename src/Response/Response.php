<?php

declare(strict_types=1);

namespace VendingMachine\Response;

abstract class Response implements \Stringable
{
    abstract public function result(): mixed;
}
