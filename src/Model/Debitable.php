<?php

declare(strict_types=1);

namespace Wallet\Model;

interface Debitable
{
    public function debit(Money $amount): void;
}
