<?php

declare(strict_types=1);

namespace Wallet\Model;

use InvalidArgumentException;

final class DbId implements SingleValueObject
{
    use SingleValueObjectBehavior;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException();
        }

        $this->value = $value;
    }
}
