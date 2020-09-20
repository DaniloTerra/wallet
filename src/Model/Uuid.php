<?php

declare(strict_types=1);

namespace Wallet\Model;

use InvalidArgumentException;

final class Uuid implements SingleValueObject
{
    private const PATTERN = '/^[0-9a-fA-F]{32}$/';

    use SingleValueObjectBehavior;

    public function __construct(string $value)
    {
        if (preg_match(sprintf("/%s/", static::PATTERN), $value)) {
            throw new InvalidArgumentException();
        }

        $this->value = $value;
    }

    public static function generate(): self
    {
        // implementar esse método fora... Está aqui para teste
        return new static('dfb3cdf681c64869ac2d0951459ff859');
    }
}
