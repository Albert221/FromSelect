<?php

namespace FromSelect;

use FromSelect\Controller\AbstractController;
use FromSelect\Controller\ControllerDecorator;
use Interop\Container\ContainerInterface;
use Slim\CallableResolver;
use Slim\Interfaces\CallableResolverInterface;

class DecoratingCallableResolver implements CallableResolverInterface
{
    /**
     * @var CallableResolver
     */
    private $callableResolver;

    /**
     * @var ControllerDecorator
     */
    private $controllerDecorator;

    /**
     * DecoratingCallableResolver constructor.
     *
     * @param ContainerInterface $container
     * @param ControllerDecorator $controllerDecorator
     */
    public function __construct(
        ContainerInterface $container,
        ControllerDecorator $controllerDecorator
    ) {
        $this->callableResolver = new CallableResolver($container);
        $this->controllerDecorator = $controllerDecorator;
    }

    /**
     * Invokes resolved callable and decorates it if is a subclass
     * of AbstractController.
     *
     * @param mixed $toResolve
     * @return callable
     */
    public function resolve($toResolve)
    {
        $resolved = $this->callableResolver->resolve($toResolve);

        // Check against resolved value for callable class or against first
        // value for callable array.
        if (($controller = $resolved) instanceof AbstractController
            || is_array($controller) && ($controller = $resolved[0]) instanceof AbstractController) {
            $this->controllerDecorator->decorate($controller);
        }

        return $resolved;
    }
}
