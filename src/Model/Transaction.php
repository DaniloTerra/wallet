<?php

declare(strict_types=1);

namespace Wallet\Model;

final class Transaction implements ValueObject
{
    private Nature $nature;

    private Money $amount;

    public function __construct(Nature $nature, Money $amount)
    {
        $this->nature = $nature;
        $this->amount = $amount;
    }

    public function getNature(): Nature
    {
        return $this->nature;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function isDebit(): bool
    {
        return $this->nature->equals(new Nature(Nature::DEBIT));
    }

    public function isCredit(): bool
    {
        return $this->nature->equals(new Nature(Nature::CREDIT));
    }

    public static function debit(Money $amount): self
    {
        return new static(
            new Nature(Nature::DEBIT),
            $amount
        );
    }

    public static function credit(Money $amount): self
    {
        return new static(
            new Nature(Nature::CREDIT),
            $amount
        );
    }
}
