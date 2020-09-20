<?php

declare(strict_types=1);

namespace Wallet\Model;

use ReflectionClass;
use InvalidArgumentException;

class Enum implements SingleValueObject
{
    protected $value;

    public function __construct($value)
    {
        $constants = (new ReflectionClass(static::class))->getConstants();

        if (!array_search($value, $constants, true)) {
            throw new InvalidArgumentException();
        }

        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function equals(self $instance): bool
    {
        return $instance->getValue() === $this->value;
    }
}
