<?php

/** @var $app FromSelect */

use FromSelect\Controller\DatabaseController;
use FromSelect\Controller\ConnectionController;
use FromSelect\Controller\TableController;
use FromSelect\FromSelect;

$app->get('/', DatabaseController::class.':all')->setName('databases.all');

$app->get('/connect', ConnectionController::class.':connect')->setName('connection.connect');
$app->post('/connect', ConnectionController::class.':auth')->setName('connection.auth');
$app->get('/disconnect', ConnectionController::class.':disconnect')->setName('connection.disconnect');

$app->get('/db/new', DatabaseController::class.':newAction')->setName('databases.new');
$app->get('/db/{database}', DatabaseController::class.':show')->setName('databases.show');

$app->get('/db/{database}/{table}', TableController::class.':show')->setName('tables.show');
$app->get('/db/{database}/{table}/structure', TableController::class.':structure')->setName('tables.structure');
