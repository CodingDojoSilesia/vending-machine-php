<?php

declare(strict_types=1);

namespace VendingMachine\Domain\Coin\Exception;

use Throwable;
use RuntimeException;
use VendingMachine\Domain\Coin\ShortCode;

final class CoinAlreadyExist extends RuntimeException
{
    public function __construct(ShortCode $shortCode, $code = 0, Throwable $previous = null)
    {
        $message = sprintf('Coin with shortcode "%s" already exists.', $shortCode->getCode());

        parent::__construct($message, $code, $previous);
    }
}
