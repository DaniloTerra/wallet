<?php

declare(strict_types=1);

namespace Wallet\Model;

interface Authorizer
{
    /**
     * @throws TransferNotAuthorizedException
     */
    public function authorize(): void;
}
