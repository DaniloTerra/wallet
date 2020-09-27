<?php

declare(strict_types=1);

namespace Wallet\Port;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Wallet\Application\Command\Transfer;
use Wallet\Application\Notifier;
use Wallet\Model\AccountRepository;
use Wallet\Model\Authorizer;
use Wallet\Model\TransferService;

$app = AppFactory::createFromContainer($container);

$app->post('/transaction', function (Request $request, Response $response, $args) use ($container) {
    $contents = json_decode(file_get_contents('php://input'), true);

    $command = new Transfer(
        $container->get(AccountRepository::class),
        $container->get(Notifier::class),
        $container->get(Authorizer::class)
    );

    $command->transfer(
        $contents['payer'],
        $contents['payee'],
        $contents['value']
    );

    return $response;
});


$app->run();
