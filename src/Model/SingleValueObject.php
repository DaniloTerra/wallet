<?php

declare(strict_types=1);

namespace Wallet\Model;

interface SingleValueObject
{
    public function getValue();

    public function equals(self $instance): bool;
}
