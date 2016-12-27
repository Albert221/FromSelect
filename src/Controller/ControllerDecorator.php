<?php

namespace FromSelect\Controller;

use Slim\Interfaces\RouterInterface;
use Slim\Views\Twig;

class ControllerDecorator
{
    /**
     * @var Twig
     */
    private $twig;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * ControllerDecorator constructor.
     *
     * @param Twig $twig
     * @param RouterInterface $router
     */
    public function __construct(Twig $twig, RouterInterface $router)
    {
        $this->twig = $twig;
        $this->router = $router;
    }

    /**
     * Decorator method which calls pseudo constructor on controller to set
     * common dependencies.
     *
     * @param AbstractController $controller
     */
    public function decorate(AbstractController $controller)
    {
        $controller->pseudoConstructor($this->twig, $this->router);
    }
}
