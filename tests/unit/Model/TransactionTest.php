<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \Wallet\Model\Transaction
 */
final class TransactionTest extends Unit
{
    /**
     * @covers ::debit
     * @covers ::__construct
     * @covers ::getNature
     * @covers ::getAmount
     * @covers ::isDebit
     */
    public function testDebitTransaction()
    {
        $amount = new Money(10.00);
        $nature = new Nature(Nature::DEBIT);

        $debit = Transaction::debit($amount);

        static::assertEquals($amount, $debit->getAmount());
        static::assertEquals($nature, $debit->getNature());
        static::assertTrue($debit->isDebit());
    }

    /**
     * @covers ::credit
     * @covers ::__construct
     * @covers ::getNature
     * @covers ::getAmount
     * @covers ::isCredit
     */
    public function testCreditTransaction()
    {
        $amount = new Money(10.00);
        $nature = new Nature(Nature::CREDIT);

        $credit = Transaction::credit($amount);

        static::assertEquals($amount, $credit->getAmount());
        static::assertEquals($nature, $credit->getNature());
        static::assertTrue($credit->isCredit());
    }
}
