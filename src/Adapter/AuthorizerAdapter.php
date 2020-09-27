<?php

declare(strict_types=1);

namespace Wallet\Adapter;

use GuzzleHttp\Client as HttpClient;
use Wallet\Model\Authorizer;
use Wallet\Model\TransferNotAuthorizedException;

final class AuthorizerAdapter implements Authorizer
{
    private const AUTHORIZER_URL = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    public function authorize(): void
    {
        try {
            $response = $this->http->get(static::AUTHORIZER_URL);

            $body = json_decode((string)$response->getBody(), true);
            $isAuthorized = $body['message'] === 'Autorizado';

            if ($isAuthorized) {
                return;
            }

            throw new \Exception('Transaction not authorized');
        } catch (\Exception $error) {
            throw new TransferNotAuthorizedException();
        }
    }
}
