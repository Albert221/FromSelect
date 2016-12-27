<?php

/** @var $container \Slim\Container */

use FromSelect\Controller\DatabaseController;
use FromSelect\Controller\TestController;
use FromSelect\Repository\ArrayDatabaseRepository;

$container[TestController::class] = function () {
    return new TestController(new ArrayDatabaseRepository());
};

$container[DatabaseController::class] = function () {
    return new DatabaseController(new ArrayDatabaseRepository());
};