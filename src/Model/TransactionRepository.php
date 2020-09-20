<?php

declare(strict_types=1);

namespace Wallet\Model;

interface TransactionRepository
{
    public function push(DbId $userId, Transaction $transaction): void;
}
