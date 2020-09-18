<?php

declare(strict_types=1);

namespace Wallet\Model;

final class User
{
    private Money $balance;

    public function __construct()
    {
        $this->balance = new Money(0.00);
    }

    public function debit(Money $amount): void
    {
        $this->balance = $this->balance->decrease($amount);
    }

    public function credit(Money $amount): void
    {
        $this->balance = $this->balance->increase($amount);
    }

    public function getBalance(): Money
    {
        return $this->balance;
    }
}
