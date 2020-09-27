<?php

declare(strict_types=1);

namespace Wallet\Application\Command;

use Wallet\Application\Notifier;
use Wallet\Model\AccountRepository;
use Wallet\Model\Authorizer;
use Wallet\Model\DbId;
use Wallet\Model\Money;
use Wallet\Model\TransferService;
use Wallet\Model\Transfer as AggregateRoot;
use Wallet\Model\Uuid;

final class Transfer
{
    private AccountRepository $accountRepository;

    private Notifier $notifier;

    private Authorizer $authorizer;

    public function __construct(
        AccountRepository $accountRepository,
        Notifier $notifier,
        Authorizer $authorizer
    ) {
        $this->accountRepository = $accountRepository;
        $this->notifier = $notifier;
        $this->authorizer = $authorizer;
    }

    public function transfer(int $payer, int $payee, float $amount)
    {
        $payerEntity = $this->accountRepository->get(new DbId($payer));
        $payeeEntity = $this->accountRepository->get(new DbId($payee));
        $amountMoney = new Money($amount);

        $aggregate = new AggregateRoot(
            Uuid::generate(),
            $this->authorizer
        );

        $transferred = $aggregate->transfer($payerEntity, $payeeEntity, $amountMoney);
        $this->accountRepository->push($transferred);

        $this->notifier->notify(
            $payer,
            $payee,
            $amount,
            sprintf("Você recebeu uma transferência no valor de %s", $amount
        ));
    }
}
