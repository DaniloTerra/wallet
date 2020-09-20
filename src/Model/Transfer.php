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

    public function transfer(Debitable $payer, Creditable $payee, Money $amount)
    {
        $this->authorize();

        $payer->debit($amount);
        $payee->credit($amount);
    }

    private function authorize()
    {
        $this->authorizer->authorize();
    }
}
