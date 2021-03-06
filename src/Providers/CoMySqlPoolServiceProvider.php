<?php

namespace BL\Slumen\Providers;

use BL\Slumen\Database\CoMySqlManager;
use BL\Slumen\Database\CoMySqlPoolConnection;

class CoMySqlPoolServiceProvider extends ServiceProvider
{
    const PROVIDER_NAME = 'SlumenCoMySqlPool';

    public function register()
    {
        $this->app->singleton(self::PROVIDER_NAME, function ($app) {
            app('db');
            $config = app()['config']['database.connections.mysql'];
            if ($config) {
                $db_pool = config('slumen.db_pool');
                $pdo     = new CoMySqlManager([
                    'host'        => $config['host'],
                    'port'        => $config['port'],
                    'user'        => $config['username'],
                    'password'    => $config['password'],
                    'database'    => $config['database'],
                    'charset'     => $config['charset'],
                    'strict_type' => $config['strict'],
                    'fetch_mode'  => true,
                    'timeout'     => -1,
                ], $db_pool['max_connection'], $db_pool['min_connection']);
                return new CoMySqlPoolConnection($pdo, $config['database'], $config['prefix'], $config);
            }
            return null;
        });
    }
}
