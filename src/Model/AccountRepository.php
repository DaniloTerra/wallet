<?php

declare(strict_types=1);

namespace Wallet\Model;

interface AccountRepository
{
    public function get(DbId $id): Account;

    public function push(MoneyTransferred $event): void;
}
