<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \Wallet\Model\Wallet
 */
final class WalletTest extends Unit
{
    /**
     * @covers ::__construct
     * @covers ::fresh
     * @covers ::getBalance
     */
    public function testGetBalanceFromAnEmptyWalletShouldReturnZeroMoney()
    {
        $wallet = Wallet::fresh();

        $expectedBalance = new Money(0.00);

        static::assertEquals($expectedBalance, $wallet->getBalance());
    }


    /**
     * @covers ::__construct
     * @covers ::fresh
     * @covers ::debit
     */
    public function testDebitFromAnEmptyWalletShouldThrowsAnException()
    {
        $wallet = Wallet::fresh();
        $debit = new Money(10.00);

        static::expectException(InsufficientBalanceException::class);
        $wallet->debit($debit);
    }


    /**
     * @covers ::__construct
     * @covers ::fresh
     * @covers ::credit
     * @covers ::getBalance
     */
    public function testCreditFromAnEmptyWalletShouldIncreaseBalance()
    {
        $wallet = Wallet::fresh();
        $credit = new Money(10.00);

        $wallet->credit($credit);

        static::assertEquals($credit, $wallet->getBalance());
    }


    /**
     * @covers ::fresh
     * @covers ::credit
     * @covers ::debit
     * @covers ::getBalance
     */
    public function testCreditThenDebitShouldResultInAZeroBalance()
    {
        $wallet = Wallet::fresh();
        $amount = new Money(25.00);

        $wallet->credit($amount);
        $wallet->debit($amount);

        $zero = new Money(0.00);

        static::assertEquals($zero, $wallet->getBalance());
    }


    /**
     * @covers ::__construct
     * @covers ::fresh
     * @covers ::fromTransactions
     * @covers ::apply
     * @covers ::debit
     * @covers ::getBalance
     */
    public function testDebitFromExitingWalletShouldDecreaseBalance()
    {
        $transactions = new TransactionCollection();
        $transactions->push(Transaction::credit(new Money(10.00)));
        $transactions->push(Transaction::credit(new Money(10.00)));
        $transactions->push(Transaction::credit(new Money(10.00)));
        $transactions->push(Transaction::credit(new Money(10.00)));
        $transactions->push(Transaction::credit(new Money(10.00)));

        $transactions->push(Transaction::credit(new Money(10.00)));
        $transactions->push(Transaction::debit(new Money(10.00)));


        $wallet = Wallet::fromTransactions($transactions);
        $wallet->debit(new Money(10.00));

        static::assertEquals(new Money(40.00), $wallet->getBalance());
    }
}
