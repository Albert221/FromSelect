<?php

/** @var $app \FromSelect\FromSelect */

$app->get('/', \FromSelect\Controller\TestController::class);
$app->get('/database/{database}', 'FromSelect\Controller\DatabaseController:show')->setName('database.show');