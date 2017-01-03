<?php

/** @var $container \Slim\Container */

use FromSelect\Controller\DatabaseController;
use FromSelect\Controller\TableController;
use FromSelect\Controller\TestController;
use FromSelect\Repository\DatabaseRepository;
use FromSelect\Repository\TableRepository;

$container[DatabaseRepository::class] = function ($c) {
    return new \FromSelect\Repository\MySQLDatabaseRepository($c['pdo']);
};

// @TODO: Move this to a better place.
$container->extend('view', function (\Slim\Views\Twig $twig, $c) {
    $twig->getEnvironment()->addGlobal('databaseTree',
        $c[DatabaseRepository::class]->getTree());

    return $twig;
});

$container[TableRepository::class] = function ($c) {
    return new \FromSelect\Repository\MySQLTableRepository($c['pdo']);
};

$container[TestController::class] = function ($c) {
    return new TestController($c[DatabaseRepository::class]);
};

$container[DatabaseController::class] = function ($c) {
    return new DatabaseController($c[DatabaseRepository::class]);
};

$container[TableController::class] = function ($c) {
    return new TableController($c[TableRepository::class]);
};
