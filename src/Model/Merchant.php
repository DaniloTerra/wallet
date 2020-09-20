<?php

declare(strict_types=1);

namespace Wallet\Model;

final class Merchant extends Account implements Creditable
{
    public function debit(Money $amount): void
    {
        // Fere princípio de Liskov. A abstração deve melhorar
        throw new TransferNotAuthorizedException();
    }


    public function credit(Money $amount): void
    {
        $this->wallet->credit($amount);
    }
}
