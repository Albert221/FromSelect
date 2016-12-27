<?php

namespace FromSelect;

use FromSelect\Controller\ControllerDecorator;
use FromSelect\Controller\TestController;
use FromSelect\Repository\ArrayDatabaseRepository;
use FromSelect\ServiceProvider\RouteServiceProvider;
use FromSelect\ServiceProvider\ServiceProviderInterface;
use FromSelect\ServiceProvider\TwigServiceProvider;
use Slim\App;

class FromSelect extends App
{
    /**
     * @var bool Is application in debug mode?
     */
    public $debug;

    /**
     * @var ServiceProviderInterface[] Stack of service providers.
     */
    private $serviceProviders = [];

    /**
     * FromSelect constructor.
     *
     * @param bool $debug
     */
    public function __construct($debug = false)
    {
        parent::__construct([
            'settings' => [
                'displayErrorDetails' => $this->debug = $debug
            ]
        ]);

        $this->registerServices();
        $this->provideServices();
    }

    /**
     * Register service providers.
     */
    protected function registerServices()
    {
        $container = $this->getContainer();

        $this->serviceProviders[] = new TwigServiceProvider();
        $this->serviceProviders[] = new RouteServiceProvider();

        // @TODO: Separate this to a service provider
        $container['callableResolver'] = function ($c) {
            $decorator = new ControllerDecorator($c['view'], $c['router']);

            return new DecoratingCallableResolver($c, $decorator);
        };

        $container[TestController::class] = function () {
            return new TestController(new ArrayDatabaseRepository());
        };
    }

    /**
     * Call every provider to store its services in container.
     */
    protected function provideServices()
    {
        foreach ($this->serviceProviders as $serviceProvider) {
            $serviceProvider->provide($this);
        }
    }
}
