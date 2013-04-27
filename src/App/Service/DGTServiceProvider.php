<?php
namespace App\Service;

use Silex\Application;
use Silex\ServiceProviderInterface;

class DGTServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        if(!isset($app['dgt.class'])) {
            $app['dgt.class'] = 'App\Service\XMLReaderService';
        }

        if(!isset($app['dgt.url'])) {
            $app['dgt.url'] = 'http://www.dgt.es/incidenciasXY.xml';
        }

        $app['dgt'] = $app->share(function ($app) {
            return new $app['dgt.class']('dgt', $app['dgt.url'], $app['cache']);
        });
    }

    public function boot(Application $app)
    {
    }
}
