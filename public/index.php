<?php

require '../vendor/autoload.php';

// Determine if the server address is the same as the remote address to set debug.
$debug = $_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR'];

// Create new instance of FromSelect class which is the application core itself
// and does all the things such as providing services, adding middlewares,
// and doing the things related to routing behind the mask.
$app = new \FromSelect\FromSelect($debug);

// Gets request and response from application's container and processes it
// to be sent to the client browser.
$app->run();
