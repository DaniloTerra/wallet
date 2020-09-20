<?php

declare(strict_types=1);

namespace Wallet\Model;

trait SingleValueObjectBehavior
{
    private $value;

    public function getValue()
    {
        return $this->value;
    }

    public function equals($instance): bool
    {
        return $instance->getValue() === $this->value;
    }
}
