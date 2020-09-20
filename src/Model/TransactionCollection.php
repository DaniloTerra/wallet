<?php

declare(strict_types=1);

namespace Wallet\Model;

use InvalidArgumentException;

final class TransactionCollection implements Collection
{
    private array $items = [];

    public function push($item): void
    {
        if (!is_a($item, Transaction::class)) {
            throw new InvalidArgumentException();
        }

        array_push($this->items, $item);
    }

    public function getList(): array
    {
        return $this->items;
    }
}
