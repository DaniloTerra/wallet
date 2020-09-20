<?php

declare(strict_types=1);

namespace Wallet\Model;

use DomainException;

final class InsufficientBalanceException extends DomainException
{
}
