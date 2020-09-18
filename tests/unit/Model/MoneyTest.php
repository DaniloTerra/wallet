<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \Wallet\Model\Money
 */
final class MoneyTest extends Unit
{
    /**
     * @covers ::__construct
     */
    public function testConstructWithPositiveValue()
    {
        $value = 100.00;

        $amount = new Money($value);

        static::assertInstanceOf(Money::class, $amount);
    }


    /**
     * @covers ::__construct
     */
    public function testConstructWithNegativeValueShouldThrowException()
    {
        static::expectException(\InvalidArgumentException::class);

        new Money(-100.00);
    }


    /**
     * @covers ::increase
     */
    public function testIncreaseShouldReturnAnIncreasedInstance()
    {
        $amount = new Money(100.00);

        $increased = $amount->increase(new Money(100.00));

        static::assertNotSame($amount, $increased);
        static::assertEquals(200.00, $increased->getValue());
    }

    /**
     * @covers ::increase
     */
    public function testDecreaseShouldReturnADecreasedInstance()
    {
        $amount = new Money(200.00);

        $increased = $amount->decrease(new Money(100.00));

        static::assertNotSame($amount, $increased);
        static::assertEquals(100.00, $increased->getValue());
    }
}
