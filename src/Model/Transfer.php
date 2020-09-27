<?php

declare(strict_types=1);

namespace Wallet\Model;

final class Transfer
{
    private Uuid $identification;

    private Authorizer $authorizer;

    public function __construct(
        Uuid $identification,
        Authorizer $authorizer
    ) {
        $this->identification = $identification;
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
