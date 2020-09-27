<?php

declare(strict_types=1);

namespace Wallet\Application\Command;

use Wallet\Adapter\AccountRepositoryAdapter;
use Wallet\Adapter\AuthorizerAdapter;
use Wallet\Adapter\NotifierAdapter;
use Wallet\Application\Notifier;
use Wallet\Model\AccountRepository;
use Wallet\Model\DbId;
use Wallet\Model\Money;
use Wallet\Model\TransferService;

final class Transfer
{
    private AccountRepository $accountRepository;

    private TransferService $transferService;

    private Notifier $notifier;

    public function __construct(
        AccountRepository $accountRepository,
        TransferService $transferService,
        Notifier $notifier
    ) {
        $this->accountRepository = $accountRepository;
        $this->transferService = $transferService;
        $this->notifier = $notifier;
    }

    public function transfer(int $payer, int $payee, float $amount)
    {
        try {
            $payerEntity = $this->accountRepository->get(new DbId($payer));
            $payeeEntity = $this->accountRepository->get(new DbId($payee));
            $amountMoney = new Money($amount);

            // Start Transaction
            $this->transferService->transfer($payerEntity, $payeeEntity, $amountMoney);

            print_r('terminou de fazer a transação'); exit;
        } catch (\Exception $error) {
            // Rollback
        }

        // Notificação pode falhar sem corromper a consistência dos dados
        $this->notifier->notify(
            $payer,
            $payee,
            $amount,
            sprintf("Você recebeu uma transferência no valor de %s", $amount
        ));
    }
}
