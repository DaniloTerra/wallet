<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \Wallet\Model\User
 */
final class UserTest extends Unit
{
    private function walletWithBalance()
    {
        $wallet = Wallet::fresh();
        $wallet->credit(new Money(500.00));
        return $wallet;
    }

    /**
     * @covers ::debit
     */
    public function testUserDebitShouldDecreaseTheirWalletBalance()
    {
        $user = new User($this->walletWithBalance());
        $initialBalance = $user->getBalance();

        $debit = new Money(50.00);

        $expectedBalance = $initialBalance->decrease($debit);

        $user->debit($debit);

        static::assertTrue($expectedBalance->equals($user->getBalance()));
    }


    /**
     * @covers ::credit
     */
    public function testUserCreditShouldIncreaseTheirWalletBalance()
    {
        $user = new User($this->walletWithBalance());
        $initialBalance = $user->getBalance();

        $credit = new Money(50.00);

        $expectedBalance = $initialBalance->increase($credit);

        $user->credit($credit);

        static::assertTrue($expectedBalance->equals($user->getBalance()));
    }
}
