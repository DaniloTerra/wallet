<?php

declare(strict_types=1);

namespace Wallet\Port;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Wallet\Application\Command\Transfer as Command;
use Wallet\Application\Notifier;
use Wallet\Model\AccountRepository;
use Wallet\Model\Authorizer;

$app = AppFactory::createFromContainer($container);

$app->post('/transaction', function (Request $request, Response $response, $args) use ($container) {
    try {
        $body = json_decode(file_get_contents('php://input'), true);

        $command = new Command(
            $container->get(AccountRepository::class),
            $container->get(Notifier::class),
            $container->get(Authorizer::class)
        );

        $command->transfer(
            $body['payer'],
            $body['payee'],
            $body['value']
        );

        $response = $response->withStatus(204);
        return $response;
    } catch (\DomainException $error) {
        $response = $response->withStatus(400);
        $response->getBody()->write(json_encode(['error' => 'Transfer failed']));
        return $response;
    } catch (\Exception $error) {
        $response = $response->withStatus(500);
        $response->getBody()->write(json_encode(['error' => 'Transfer failed']));
        return $response;
    }
})->add(function (Request $request, RequestHandlerInterface $handler) {
    return $handler->handle($request)->withHeader('Content-Type', 'application/json');
});

$app->run();
