<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

final class NatureTest extends Unit
{
    /**
     * @dataProvider validValues
     */
    public function testConstructionWithValidValuesShouldReturnAnInstance($value)
    {
        $nature = new Nature($value);

        static::assertInstanceOf(Enum::class, $nature);
        static::assertEquals($value, $nature->getValue());
    }

    public function validValues()
    {
        return [
            [Nature::DEBIT],
            [Nature::CREDIT],
        ];
    }


    /**
     * @dataProvider invalidValues
     */
    public function testConstructionWithInvalidValuesShouldThrowsAnException($value)
    {
        static::expectException(\InvalidArgumentException::class);
        new Nature($value);
    }

    public function invalidValues()
    {
        return [
            ['invalid'],
            ['super invalid'],
            [''],
            [false],
            [true],
            [10],
            [100.00],
            [new \stdClass()],
        ];
    }


    public function testEqualityByValue()
    {
        $debit1 = new Nature(Nature::DEBIT);
        $debit2 = new Nature(Nature::DEBIT);

        $credit1 = new Nature(Nature::CREDIT);
        $credit2 = new Nature(Nature::CREDIT);

        static::assertTrue($debit1->equals($debit2));
        static::assertTrue($credit1->equals($credit2));
        static::assertFalse($debit1 === $debit2);
        static::assertFalse($credit1 === $credit2);

    }
}
