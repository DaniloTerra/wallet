<?php

declare(strict_types=1);

namespace Wallet\Model;

interface Collection
{
    public function push($item): void;

    public function getList(): array;
}
