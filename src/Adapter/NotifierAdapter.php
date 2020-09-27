<?php

declare(strict_types=1);

namespace Wallet\Adapter;

use Wallet\Application\Notifier;

final class NotifierAdapter implements Notifier
{
    public function notify(int $payer, int $payee, float $value, string $message)
    {
        // TODO: Implement notify() method.
    }
}
