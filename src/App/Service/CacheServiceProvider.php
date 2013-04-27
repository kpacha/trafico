<?php
namespace App\Service;

use Silex\Application;
use Silex\ServiceProviderInterface;

class CacheServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        if(!isset($app['cache.class'])) {
            $app['cache.class'] = 'Predis\Client';
        }

        if(!isset($app['cache.host'])) {
            $app['cache.host'] = $app['parameters']['redis']['host'];
        }

        if(!isset($app['cache.port'])) {
            $app['cache.port'] = $app['parameters']['redis']['port'];
        }

        if(!isset($app['cache.password'])) {
            $app['cache.password'] = $app['parameters']['redis']['password'];
        }

        if(!isset($app['cache.connection'])) {
            $app['cache.connection'] = array(
                'host' => $app['cache.host'], 
                'port' => $app['cache.port'],
                'password' => $app['cache.password'], 
            );
        }

        $app['cache'] = $app->share(function ($app) {
            return new $app['cache.class']($app['cache.connection']);
        });
    }

    public function boot(Application $app)
    {
    }
}
