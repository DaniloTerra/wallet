<?php

declare(strict_types=1);

namespace Wallet\Model;

final class MoneyTransferred implements ValueObject
{
    private Account $payer;

    private Account $payee;

    private Money $amount;


    public function __construct(Account $payer, Account $payee, Money $amount)
    {
        $this->payer = $payer;
        $this->payee = $payee;
        $this->amount = $amount;
    }


    public function getPayer(): Account
    {
        return $this->payer;
    }


    public function getPayee(): Account
    {
        return $this->payee;
    }


    public function getAmount(): Money
    {
        return $this->amount;
    }
}
