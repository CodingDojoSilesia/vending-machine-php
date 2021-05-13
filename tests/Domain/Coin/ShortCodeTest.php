<?php
declare(strict_types=1);

namespace VendingMachine\Domain\Coin;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ShortCodeTest extends TestCase
{
    public function testCreate(): ShortCode
    {
        $shortCode = ShortCode::fromString('N');
        $this->assertInstanceOf(ShortCode::class, $shortCode);

        return $shortCode;
    }

    /**
     * @param ShortCode $shortCode
     *
     * @depends testCreate
     */
    public function testGetter(ShortCode $shortCode)
    {
        $this->assertEquals('N', $shortCode->getCode());
    }

    public function testTryCreateWithInvalidShortCode()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('Illegal shortcode "F".');
        ShortCode::fromString('F');
    }
}
