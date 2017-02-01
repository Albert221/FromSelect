<?php

namespace FromSelect\ServiceProvider;

use FromSelect\Controller\ControllerDecorator;
use FromSelect\DecoratingCallableResolver;
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

        $app->getContainer()['callableResolver'] = function ($c) {
            $decorator = new ControllerDecorator($c['view'], $c['router']);

            return new DecoratingCallableResolver($c, $decorator);
        };
    }
}
