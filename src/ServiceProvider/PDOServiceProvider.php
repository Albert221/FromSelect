<?php

namespace FromSelect\ServiceProvider;

use FromSelect\FromSelect;
use FromSelect\PDO\PDO;

class PDOServiceProvider implements ServiceProviderInterface
{
    /**
     * Provides `pdo`.
     *
     * @param FromSelect $app
     */
    public function provide(FromSelect $app)
    {
        $config = $this->getConfig();

        $app->getContainer()['pdo'] = function () use ($config) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;charset=utf8',
                $config['host'],
                $config['port']
            );

            $pdo = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);

            return $pdo;
        };
    }

    private function getConfig()
    {
        $defaultConfig = [
            'allow_overrides' => false,
            'host' => 'localhost',
            'port' => 3306,
            'username' => 'root',
            'password' => null
        ];

        $iniConfigPath = dirname(dirname(__DIR__)).'/config.ini';

        if (file_exists($iniConfigPath)) {
            $iniConfig = parse_ini_file($iniConfigPath, true)['connection'];
        } else {
            $iniConfig = [];
        }

        $sessionConfig = isset($_SESSION['connection']) ? $_SESSION['connection'] : [];

        return array_merge(array_merge($defaultConfig, $iniConfig), $sessionConfig);
    }
}
