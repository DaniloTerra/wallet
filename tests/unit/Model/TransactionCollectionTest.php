<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

final class TransactionCollectionTest extends Unit
{
    /**
     * @dataProvider validValues
     */
    public function testPushCollectionWithValidValues($item)
    {
        $collection = new TransactionCollection();

        $collection->push($item);

        static::assertEquals([$item], $collection->getList());
    }

    public function validValues()
    {
        return [
            [Transaction::debit(new Money(10.00))],
            [Transaction::credit(new Money(10.00))],
        ];
    }


    /**
     * @dataProvider invalidValues
     */
    public function testPushCollectionWithInvalidValues($item)
    {
        $collection = new TransactionCollection();

        static::expectException(\InvalidArgumentException::class);

        $collection->push($item);
    }

    public function invalidValues()
    {
        return [
            [''],
            ['invalid value'],
            [true],
            [false],
            [new \stdClass()],
        ];
    }
}
