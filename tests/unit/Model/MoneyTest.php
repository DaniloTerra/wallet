<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \Wallet\Model\Money
 */
final class MoneyTest extends Unit
{
    public function testConstructWithNegativeValueShouldThrowException()
    {
        static::expectException(\InvalidArgumentException::class);

        new Money(-100.00);
    }
}
