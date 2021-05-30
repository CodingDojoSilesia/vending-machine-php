<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin;

use Stringable;
use InvalidArgumentException;
use function mb_strtoupper;

final class ShortCode implements Stringable
{
    public const   VALID_SHORTCODES = [
        'N'   => 5,
        'D'   => 10,
        'Q'   => 25,
        'DOL' => 100
    ];

    private string $code;

    private function __construct(string $shortCode)
    {
        $this->validate($shortCode);
        $this->code = $shortCode;
    }

    public static function fromString(string $shortCode): self
    {
        return new self($shortCode);
    }

    public function __toString(): string
    {
        return $this->getCode();
    }

    public function getCode(): string
    {
        return $this->code;
    }

    private function validate(string $shortCode): void
    {
        if (!in_array(mb_strtoupper($shortCode), array_keys(self::VALID_SHORTCODES), true)) {
            throw new InvalidArgumentException(sprintf('Illegal shortcode "%s".', $shortCode));
        }
    }
}
