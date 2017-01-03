<?php

namespace FromSelect\Controller;

use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;

abstract class AbstractController
{
    /**
     * @var Twig
     */
    protected $twig;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * Pseudo constructor because the proper constructor is for child class
     * specific dependencies.
     *
     * @internal To be called only by callable resolver.
     * @param Twig $twig
     * @param RouterInterface $router
     */
    public function pseudoConstructor(Twig $twig, RouterInterface $router)
    {
        $this->twig = $twig;
        $this->router = $router;
    }
}
