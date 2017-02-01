<?php

namespace FromSelect\ServiceProvider;

use FromSelect\FromSelect;
use FromSelect\Repository\DatabaseRepository;
use FromSelect\Twig\KeyLighterExtension;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Route;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

class TwigServiceProvider implements ServiceProviderInterface
{
    /**
     * Provides `view` service.
     *
     * @param FromSelect $app
     */
    public function provide(FromSelect $app)
    {
        $app->getContainer()['view'] = function ($c) use ($app) {
            $twig = new Twig([
                'fromselect' => dirname(dirname(__DIR__)).'/resources/views'
            ], [
                'debug' => $app->debug
            ]);

            /** @var Request $request */
            $request = $c['request'];
            $twig->addExtension(new TwigExtension($c['router'], $request->getUri()));
            $twig->addExtension(new KeyLighterExtension());

            // Databases & tables sidebar tree.
            $twig->getEnvironment()->addGlobal('databaseTree',
                $c[DatabaseRepository::class]->tree());

            return $twig;
        };

        $app->add(function (Request $request, Response $response, callable $next) {
            /** @var Route $route */
            $route = $request->getAttribute('route');

            /** @var Twig $twig */
            $twig = $this['view'];

            $twig->getEnvironment()->addGlobal('route', $route);
            $twig->getEnvironment()->addGlobal('queryParams', $request->getQueryParams());

            return $next($request, $response);
        });
    }
}
