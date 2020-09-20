<?php

declare(strict_types=1);

namespace Wallet\Model;

interface Creditable
{
    public function credit(Money $amount): void;
}
