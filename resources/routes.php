<?php

/** @var $app \FromSelect\FromSelect */

use FromSelect\Controller\DatabaseController;
use FromSelect\Controller\TableController;

$app->get('/', \FromSelect\Controller\TestController::class);
$app->get('/{database}', DatabaseController::class.':show')->setName('database.show');
$app->get('/{database}/{table}', TableController::class.':show')->setName('table.show');
