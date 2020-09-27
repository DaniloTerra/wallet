<?php

declare(strict_types=1);

namespace Wallet\Model;

final class Money implements SingleValueObject
{
    use SingleValueObjectBehavior;

    public function __construct(float $value)
    {
        if ($value < 0.00) {
            throw new \InvalidArgumentException(sprintf('Invalid value "%s" for %s object', $value, static::class));
        }

        $this->value = $value;
    }

    public function increase(self $amount): self
    {
        return new static($this->value + $amount->getValue());
    }

    public function decrease(self $amount): self
    {
        return new static($this->value - $amount->getValue());
    }
}
