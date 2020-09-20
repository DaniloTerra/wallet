<?php

declare(strict_types=1);

namespace Wallet\Model;

final class Wallet
{
    private TransactionCollection $transactions;

    private function __construct(TransactionCollection $transactions)
    {
        $this->transactions = $transactions;
    }

    private function apply(Transaction $transaction)
    {
        if ($transaction->isDebit()) {
            $this->debit($transaction->getAmount());
        }

        if ($transaction->isCredit()) {
            $this->credit($transaction->getAmount());
        }
    }

    public function debit(Money $amount): void
    {
        $hasSufficientBalance = ($this->getBalance()->getValue() - $amount->getValue()) >= 0.00;
        if (!$hasSufficientBalance) {
            throw new InsufficientBalanceException();
        }

        $debit = Transaction::Debit($amount);
        $this->transactions->push($debit);
    }

    public function credit(Money $amount): void
    {
        $credit = Transaction::Credit($amount);
        $this->transactions->push($credit);
    }

    public function getBalance(): Money
    {
        $amount = new Money(0.00);
        foreach ($this->transactions->getList() as $transaction) {
            if ($transaction->isDebit()) {
                $amount = $amount->decrease($transaction->getAmount());
            }
            if ($transaction->isCredit()) {
                $amount = $amount->increase($transaction->getAmount());
            }
        }
        return $amount;
    }

    public static function fromTransactions(TransactionCollection $transactions): self
    {
        $wallet = static::fresh();

        foreach ($transactions->getList() as $transaction) {
            $wallet->apply($transaction);
        }

        return $wallet;
    }

    public static function fresh()
    {
        return new static(
            new TransactionCollection()
        );
    }
}
