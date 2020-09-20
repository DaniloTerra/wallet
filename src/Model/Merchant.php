<?php

declare(strict_types=1);

namespace Wallet\Model;

final class Merchant extends Account implements Creditable
{
    public function credit(Money $amount): void
    {
        $this->wallet->credit($amount);
    }
}
