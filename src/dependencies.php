<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface as Container;
use Doctrine\DBAL\Connection as DBConnection;
use Doctrine\DBAL\DriverManager;

$containerBuilder = new DI\ContainerBuilder();

$containerBuilder->addDefinitions([
    DBConnection::class => function () {
        // hardcoded porque se trata de uma POC
        return DriverManager::getConnection([
            'dbname' => 'wallet',
            'user' => 'root',
            'password' => 'wallet',
            'host' => 'wallet.database.intranet',
            'port' => 3306,
            'driver' => 'pdo_mysql'
        ]);
    },

    \Wallet\Model\AccountRepository::class => function (Container $container) {
        return new \Wallet\Adapter\AccountRepositoryAdapter(
            $container->get(DBConnection::class)
        );
    },

    \Wallet\Model\Authorizer::class => function () {
        return new \Wallet\Adapter\AuthorizerAdapter(
            new \GuzzleHttp\Client()
        );
    },

    \Wallet\Application\Notifier::class => function () {
        return new \Wallet\Adapter\NotifierAdapter(
            new \GuzzleHttp\Client()
        );
    }
]);

$container = $containerBuilder->build();