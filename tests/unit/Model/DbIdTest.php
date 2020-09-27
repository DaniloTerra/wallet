<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \Wallet\Model\DbId
 */
final class DbIdTest extends Unit
{
    /**
     * @covers ::__construct
     * @covers ::getValue
     *
     * @dataProvider validValues
     */
    public function testConstructionWithValidValuesShouldReturnAnInstance($value)
    {
        $id = new DbId($value);

        static::assertInstanceOf(DbId::class, $id);
        static::assertEquals($value, $id->getValue());
    }

    public function validValues(): array
    {
        return [
            [10],
            [99],
            [599],
            [15000]
        ];
    }

    /**
     * @covers ::__construct
     * @covers ::getValue
     *
     * @dataProvider invalidValues
     */
    public function testConstructionWithInvalidValuesShouldThrowsAnException($value)
    {
        static::expectException(\InvalidArgumentException::class);

        new DbId($value);
    }

    public function invalidValues(): array
    {
        return [
            [-10],
            [-99],
            [-599],
            [-15000],
            [0]
        ];
    }


    /**
     * @covers ::equals
     */
    public function testEqualityByValue()
    {
        $id1 = new DbId(10);
        $id2 = new DbId(10);

        static::assertTrue($id1->equals($id2));
        static::assertTrue($id2->equals($id1));
        static::assertFalse($id1 === $id2);
        static::assertFalse($id2 === $id1);
    }
}