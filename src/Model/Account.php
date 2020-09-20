<?php

declare(strict_types=1);

namespace Wallet\Model;

abstract class Account
{
    protected Wallet $wallet;

    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    public function getBalance(): Money
    {
        return $this->wallet->getBalance();
    }

    abstract function debit(Money $amount): void;

    abstract function credit(Money $amount): void;
}
