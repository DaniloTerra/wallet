<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \Wallet\Model\Wallet
 */
final class UserTest extends Unit
{
    /**
     * @covers ::debit
     */
    public function testUserDebitShouldDecreaseBalance()
    {
        $user = new Wallet();

        $initialBalance = $user->getBalance();
        $debitAmount = new Money(100.00);

        $user->debit($debitAmount);

        $expectedBalance = $initialBalance->decrease($debitAmount);

        static::assertEquals($expectedBalance->getValue(), $user->getBalance()->getValue());
        static::assertInstanceOf(Money::class, $initialBalance);
    }


    /**
     * @covers ::credit
     */
    public function testUserCreditShouldIncreaseBalance()
    {
        $user = new Wallet();

        $initialBalance = $user->getBalance();
        $creditAmount = new Money(100.00);

        $user->credit($creditAmount);

        $expectedBalance = $initialBalance->increase($creditAmount);

        static::assertEquals($expectedBalance->getValue(), $user->getBalance()->getValue());
    }
}
