<?php

namespace FromSelect\ServiceProvider;

use FromSelect\FromSelect;

class FromFileServiceProvider implements ServiceProviderInterface
{
    public function provide(FromSelect $app)
    {
        $container = $app->getContainer();

        require dirname(dirname(__DIR__)).'/resources/services.php';
    }
}
