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
     * @covers ::getId
     * @covers ::getBalance
     */
    public function testUser()
    {
        $id = new DbId(10);
        $wallet = Wallet::fresh();
        $user = new User($id, $wallet);

        static::assertInstanceOf(Account::class, $user);
        static::assertTrue($user->getId()->equals($id));
        static::assertTrue($user->getBalance()->equals($wallet->getBalance()));
    }


    /**
     * @covers ::__construct
     * @covers ::getId
     * @covers ::getBalance
     */
    public function testMerchant()
    {
        $id = new DbId(10);
        $wallet = Wallet::fresh();
        $merchant = new Merchant($id, $wallet);

        static::assertInstanceOf(Account::class, $merchant);
        static::assertTrue($merchant->getId()->equals($id));
        static::assertTrue($merchant->getBalance()->equals($wallet->getBalance()));
    }
}
