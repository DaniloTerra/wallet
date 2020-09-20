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
}
