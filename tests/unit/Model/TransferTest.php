<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \Wallet\Model\Transfer
 */
final class TransferTest extends Unit
{
    private function walletWithBalance()
    {
        $wallet = Wallet::fresh();
        $wallet->credit(new Money(500.00));
        return $wallet;
    }

    /**
     * @covers ::__construct
     * @covers ::transfer
     * @covers ::authorize
     */
    public function testTransferWithAuthorizationShouldMoveMoneyBetweenUsersWallet()
    {
        $authorizer = static::createMock(Authorizer::class);

        $payer = new User(new DbId(10), $this->walletWithBalance());
        $payee = new User(new DbId(20), $this->walletWithBalance());
        $payerBalance = $payer->getBalance();
        $payeeBalance = $payer->getBalance();

        $transfer = new Transfer($authorizer);
        $transferAmount = new Money(25.00);

        $expectedPayerBalance = $payerBalance->decrease($transferAmount);
        $expectedPayeeBalance = $payeeBalance->increase($transferAmount);

        $transfer->transfer($payer, $payee, $transferAmount);

        static::assertEquals($expectedPayerBalance, $payer->getBalance());
        static::assertEquals($expectedPayeeBalance, $payee->getBalance());
    }


    /**
     * @covers ::__construct
     * @covers ::transfer
     * @covers ::authorize
     */
    public function testTransferWithoutAuthorizationShouldThrowAnException()
    {
        $authorizer = static::createMock(Authorizer::class);
        $authorizer->method('authorize')->willThrowException(new TransferNotAuthorizedException());

        $payer = new User(new DbId(10), $this->walletWithBalance());
        $payee = new User(new DbId(20), $this->walletWithBalance());

        $transfer = new Transfer($authorizer);
        $transferAmount = new Money(25.00);

        static::expectException(TransferNotAuthorizedException::class);
        $transfer->transfer($payer, $payee, $transferAmount);
    }


    /**
     * @covers ::__construct
     * @covers ::transfer
     * @covers ::authorize
     */
    public function testTransferWithoutAuthorizationShouldNotMoveMoneyBetweenUsersWallet()
    {
        $authorizer = static::createMock(Authorizer::class);
        $authorizer->method('authorize')->willThrowException(new TransferNotAuthorizedException());

        $payer = new User(new DbId(10), $this->walletWithBalance());
        $payee = new User(new DbId(20), $this->walletWithBalance());
        $payerBalance = $payer->getBalance();
        $payeeBalance = $payer->getBalance();

        $transfer = new Transfer($authorizer);
        $transferAmount = new Money(25.00);

        static::expectException(TransferNotAuthorizedException::class);
        $transfer->transfer($payer, $payee, $transferAmount);

        static::assertEquals($payerBalance, $payer->getBalance());
        static::assertEquals($payeeBalance, $payee->getBalance());
    }


    /**
     * @covers ::__construct
     * @covers ::transfer
     * @covers ::authorize
     */
    public function testTransferUserToUserShouldMoveMoneyBetweenWallets()
    {
        $authorizer = static::createMock(Authorizer::class);

        $payer = new User(new DbId(10), $this->walletWithBalance());
        $payee = new User(new DbId(20), $this->walletWithBalance());
        $payerBalance = $payer->getBalance();
        $payeeBalance = $payer->getBalance();

        $transfer = new Transfer($authorizer);
        $transferAmount = new Money(25.00);

        $expectedPayerBalance = $payerBalance->decrease($transferAmount);
        $expectedPayeeBalance = $payeeBalance->increase($transferAmount);

        $transfer->transfer($payer, $payee, $transferAmount);

        static::assertEquals($expectedPayerBalance, $payer->getBalance());
        static::assertEquals($expectedPayeeBalance, $payee->getBalance());
    }


    /**
     * @covers ::__construct
     * @covers ::transfer
     * @covers ::authorize
     */
    public function testTransferUserToMerchantShouldMoveMoneyBetweenWallets()
    {
        $authorizer = static::createMock(Authorizer::class);

        $payer = new User(new DbId(10), $this->walletWithBalance());
        $payee = new Merchant(new DbId(20), $this->walletWithBalance());
        $payerBalance = $payer->getBalance();
        $payeeBalance = $payer->getBalance();

        $transfer = new Transfer($authorizer);
        $transferAmount = new Money(25.00);

        $expectedPayerBalance = $payerBalance->decrease($transferAmount);
        $expectedPayeeBalance = $payeeBalance->increase($transferAmount);

        $transfer->transfer($payer, $payee, $transferAmount);

        static::assertEquals($expectedPayerBalance, $payer->getBalance());
        static::assertEquals($expectedPayeeBalance, $payee->getBalance());
    }


    /**
     * @covers ::__construct
     * @covers ::transfer
     * @covers ::authorize
     */
    public function testTransferWithEmptyPayerWalletShouldThrowsAnException()
    {
        $authorizer = static::createMock(Authorizer::class);

        $payer = new User(new DbId(10), Wallet::fresh());
        $payee = new User(new DbId(20), $this->walletWithBalance());

        $transfer = new Transfer($authorizer);
        $transferAmount = new Money(25.00);

        static::expectException(InsufficientBalanceException::class);
        $transfer->transfer($payer, $payee, $transferAmount);
    }
}
