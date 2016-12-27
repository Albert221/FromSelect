<?php

namespace FromSelect\ServiceProvider;

use FromSelect\Controller\TestController;
use FromSelect\FromSelect;

class RouteServiceProvider implements ServiceProviderInterface
{
    /**
     * Provides routes for application.
     *
     * @param FromSelect $app
     */
    public function provide(FromSelect $app)
    {
        require dirname(dirname(__DIR__)).'/resources/routes.php';
    }
}
