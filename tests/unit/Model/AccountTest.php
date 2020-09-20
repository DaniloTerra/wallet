<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \Wallet\Model\Account
 */
final class AccountTest extends Unit
{
    /**
     * @covers ::__construct
     * @covers ::getBalance
     */
    public function testUser()
    {
        $wallet = Wallet::fresh();
        $user = new User($wallet);

        static::assertInstanceOf(Account::class, $user);
        static::assertTrue($user->getBalance()->equals($wallet->getBalance()));
    }


    /**
     * @covers ::__construct
     * @covers ::getBalance
     */
    public function testMerchant()
    {
        $wallet = Wallet::fresh();
        $merchant = new Merchant($wallet);

        static::assertInstanceOf(Account::class, $merchant);
        static::assertTrue($merchant->getBalance()->equals($wallet->getBalance()));
    }
}
