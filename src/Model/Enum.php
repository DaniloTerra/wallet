<?php

declare(strict_types=1);

namespace Wallet\Model;

use ReflectionClass;
use InvalidArgumentException;

class Enum implements SingleValueObject
{
    use SingleValueObjectBehavior;

    public function __construct($value)
    {
        $constants = (new ReflectionClass(static::class))->getConstants();

        if (!array_search($value, $constants, true)) {
            throw new InvalidArgumentException();
        }

        $this->value = $value;
    }
}
