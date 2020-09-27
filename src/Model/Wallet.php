<?php

declare(strict_types=1);

namespace Wallet\Model;

final class Wallet
{
    private TransactionCollection $transactions;

    private TransactionCollection $newTransactions;

    private function __construct(TransactionCollection $transactions)
    {
        $this->transactions = $transactions;
        $this->newTransactions = new TransactionCollection();
    }

    private function apply(Transaction $transaction)
    {
        if ($transaction->isDebit()) {
            $debit = Transaction::debit($transaction->getAmount());
            $this->transactions->push($debit);
        }

        if ($transaction->isCredit()) {
            $credit = Transaction::credit($transaction->getAmount());
            $this->transactions->push($credit);
        }
    }

    public function debit(Money $amount): void
    {
        $hasSufficientBalance = ($this->getBalance()->getValue() - $amount->getValue()) >= 0.00;
        if (!$hasSufficientBalance) {
            throw new InsufficientBalanceException();
        }

        $debit = Transaction::debit($amount);

        $this->transactions->push($debit);
        $this->newTransactions->push($debit);
    }

    public function credit(Money $amount): void
    {
        $credit = Transaction::credit($amount);

        $this->transactions->push($credit);
        $this->newTransactions->push($credit);
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

    public function getNew(): TransactionCollection
    {
        return $this->newTransactions;
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
