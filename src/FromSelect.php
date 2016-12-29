<?php

namespace FromSelect;

use FromSelect\Controller\ControllerDecorator;
use FromSelect\ServiceProvider\FromFileServiceProvider;
use FromSelect\ServiceProvider\PDODatabaseProvider;
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
        $this->serviceProviders[] = new FromFileServiceProvider();
        $this->serviceProviders[] = new PDODatabaseProvider();

        // @TODO: Separate this to a service provider
        $container['callableResolver'] = function ($c) {
            $decorator = new ControllerDecorator($c['view'], $c['router']);

            return new DecoratingCallableResolver($c, $decorator);
        };
    }

    /**
     * Call every provider to store its services in container.
     */
    protected function provideServices()
    {
        foreach ($this->serviceProviders as $serviceProvider) {
            if (! $serviceProvider instanceof ServiceProviderInterface) {
                throw new \RuntimeException(sprintf(
                    '%s must implement %s',
                    get_class($serviceProvider),
                    ServiceProviderInterface::class
                ));
            }

            $serviceProvider->provide($this);
        }
    }
}
