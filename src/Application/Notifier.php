<?php

declare(strict_types=1);

namespace Wallet\Application;

interface Notifier
{
    public function notify(int $payer, int $payee, float $value, string $message);
}
