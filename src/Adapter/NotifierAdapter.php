<?php

declare(strict_types=1);

namespace Wallet\Adapter;

use GuzzleHttp\Client as HttpClient;
use Wallet\Application\NotificationFailedException;
use Wallet\Application\Notifier;

final class NotifierAdapter implements Notifier
{
    private const NOTIFY_URL = 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04';

    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }


    public function notify(int $payer, int $payee, float $value, string $message)
    {
        try {
            $response = $this->http->get(static::NOTIFY_URL);

            $body = json_decode((string)$response->getBody(), true);
            $isAuthorized = $body['message'] === 'Enviado';

            if ($isAuthorized) {
                return;
            }

            throw new \Exception('Notification failed');
        } catch (\Exception $error) {
            throw new NotificationFailedException();
        }
    }
}
