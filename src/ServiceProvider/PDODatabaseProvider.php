<?php

namespace FromSelect\ServiceProvider;

use FromSelect\FromSelect;
use FromSelect\PDO;

class PDODatabaseProvider implements ServiceProviderInterface
{
    /**
     * Provides `pdo`.
     *
     * @param FromSelect $app
     */
    public function provide(FromSelect $app)
    {
        $container = $app->getContainer();

        $container['pdo'] = function () {
            return new PDO('mysql:host=localhost;charset=utf8', 'root', '', [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        };
    }
}
