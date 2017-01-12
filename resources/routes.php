<?php

/** @var $app \FromSelect\FromSelect */

use FromSelect\Controller\DatabaseController;
use FromSelect\Controller\LoginController;
use FromSelect\Controller\TableController;

$app->get('/', DatabaseController::class.':all')->setName('databases.all');
$app->get('/login', LoginController::class.':login')->setName('login.login');
$app->post('/login', LoginController::class.':auth')->setName('login.auth');
$app->get('/{database}', DatabaseController::class.':show')->setName('databases.show');
$app->get('/{database}/{table}', TableController::class.':show')->setName('tables.show');
