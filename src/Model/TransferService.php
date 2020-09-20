<?php

declare(strict_types=1);

namespace Wallet\Model;

final class TransferService
{
    private AccountRepository $accountRepository;

    private Authorizer $authorizer;

    public function __construct(AccountRepository $accountRepository, Authorizer $authorizer)
    {
        $this->accountRepository = $accountRepository;
        $this->authorizer = $authorizer;
    }

    public function transfer(Account $payer, Account $payee, Money $amount): void
    {
        $this->authorizer->authorize();

        $payer->debit($amount);
        $payee->credit($amount);

        $this->accountRepository->push($payer);
        $this->accountRepository->push($payee);
    }
}
