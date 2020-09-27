<?php

declare(strict_types=1);

namespace Wallet\Model;

abstract class Account
{
    protected DbId $id;

    protected Wallet $wallet;

    public function __construct(DbId $id, Wallet $wallet)
    {
        $this->id = $id;
        $this->wallet = $wallet;
    }

    public function getId(): DbId
    {
        return $this->id;
    }

    public function getBalance(): Money
    {
        return $this->wallet->getBalance();
    }

    // Achar um nome melhor para esse método
    public function getNewTransactions(): TransactionCollection
    {
        return $this->wallet->getNew();
    }

    abstract function debit(Money $amount): void;

    abstract function credit(Money $amount): void;
}
