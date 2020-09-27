<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \Wallet\Model\Merchant
 */
final class MerchantTest extends Unit
{
    private function walletWithBalance()
    {
        $wallet = Wallet::fresh();
        $wallet->credit(new Money(500.00));
        return $wallet;
    }

    /**
     * @covers ::credit
     */
    public function testMerchantCreditShouldIncreaseTheirWalletBalance()
    {
        $id = new DbId(10);
        $merchant = new Merchant($id, $this->walletWithBalance());
        $initialBalance = $merchant->getBalance();

        $credit = new Money(50.00);

        $expectedBalance = $initialBalance->increase($credit);

        $merchant->credit($credit);

        static::assertTrue($expectedBalance->equals($merchant->getBalance()));
    }


    /**
     * @covers ::debit
     */
    public function testMerchantDebitShouldThrowsAnException()
    {
        $id = new DbId(10);
        $merchant = new Merchant($id, $this->walletWithBalance());

        $debit = new Money(50.00);

        static::expectException(TransferNotAuthorizedException::class);

        $merchant->debit($debit);
    }
}
