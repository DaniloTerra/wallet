<?php

declare(strict_types=1);

namespace Wallet\Model;

interface AccountRepository
{
    public function getAccount(DbId $id): Account;

    public function addTransfer(MoneyTransferred $event): void;
}
