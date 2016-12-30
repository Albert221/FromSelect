<?php

namespace FromSelect\ServiceProvider;

use FromSelect\FromSelect;
use FromSelect\Twig\KeyLighterExtension;
use Slim\Http\Request;
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
        $container = $app->getContainer();

        $container['view'] = function ($c) use ($app) {
            $twig = new Twig([
                'fromselect' => dirname(dirname(__DIR__)).'/resources/views'
            ], [
                'debug' => $app->debug
            ]);

            /** @var Request $request */
            $request = $c['request'];
            $twig->addExtension(new TwigExtension($c['router'], $request->getUri()));
            $twig->addExtension(new KeyLighterExtension());

            return $twig;
        };
    }
}
