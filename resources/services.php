<?php

/** @var $container \Slim\Container */

use FromSelect\Controller\DatabaseController;
use FromSelect\Controller\TestController;
use FromSelect\Repository\DatabaseRepository;

$container[DatabaseRepository::class] = function ($c) {
    return new \FromSelect\Repository\MySQLDatabaseRepository($c['pdo']);
};

$container[TestController::class] = function ($c) {
    return new TestController($c[DatabaseRepository::class]);
};

$container[DatabaseController::class] = function ($c) {
    return new DatabaseController($c[DatabaseRepository::class]);
};
