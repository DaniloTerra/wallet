<?php

declare(strict_types=1);

namespace Wallet\Model;

final class Transfer
{
    private Authorizer $authorizer;

    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    public function transfer(Account $payer, Account $payee, Money $amount): MoneyTransferred
    {
        $this->authorize();

        $payer->debit($amount);
        $payee->credit($amount);

        return new MoneyTransferred($payer, $payee, $amount);
    }

    private function authorize()
    {
        $this->authorizer->authorize();
    }
}
