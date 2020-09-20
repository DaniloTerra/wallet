<?php

declare(strict_types=1);

namespace Wallet\Model;

final class User extends Account implements Creditable, Debitable
{
    public function debit(Money $amount): void
    {
        $this->wallet->debit($amount);
    }

    public function credit(Money $amount): void
    {
        $this->wallet->credit($amount);
    }
}
