<?php

/** @var $container \Slim\Container */

use FromSelect\Controller\DatabaseController;
use FromSelect\Controller\TableController;
use FromSelect\Repository\DatabaseRepository;
use FromSelect\Repository\TableRepository;

$container[DatabaseRepository::class] = function ($c) {
    return new \FromSelect\Repository\MySQLDatabaseRepository($c['pdo']);
};

$container[TableRepository::class] = function ($c) {
    return new \FromSelect\Repository\MySQLTableRepository($c['pdo']);
};

$container[DatabaseController::class] = function ($c) {
    return new DatabaseController($c[DatabaseRepository::class]);
};

$container[TableController::class] = function ($c) {
    return new TableController($c[TableRepository::class]);
};
