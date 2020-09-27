<?php

declare(strict_types=1);

namespace Wallet\Model;

use Codeception\Test\Unit;

/**
 * @coversDefaultClass \Wallet\Model\MoneyTransferred
 */
final class MoneyTransferredTest extends Unit
{
    /**
     * @covers ::__construct
     * @covers ::getPayer
     * @covers ::getPayee
     * @covers ::getAmount
     */
    public function testConstruction()
    {
        $payer = new User(new DbId(10), Wallet::fresh());
        $payee = new Merchant(new DbId(10), Wallet::fresh());
        $amount = new Money(15.00);

        $event = new MoneyTransferred($payer, $payee, $amount);

        static::assertInstanceOf(MoneyTransferred::class, $event);
        static::assertEquals($payer, $event->getPayer());
        static::assertEquals($payee, $event->getPayee());
        static::assertEquals($amount, $event->getAmount());
    }
}
