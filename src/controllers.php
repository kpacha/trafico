<?php

use Symfony\Component\HttpFoundation\Response;

$app->get('/', function () use ($app) {
    $response = new Response;
    $content = $app['cache']->get('home');
    if (!$content) {
        $content = $app['twig']->render(
                'map.twig',
                array('google_api_key' => $app['parameters']['google.api.key'])
            );
        $app['cache']->set('home', $content);
    }
    $response->setContent($content);
    $response->setPublic();
    $date = new DateTime();
    $date->modify('+1 month');
    $response->setExpires($date);
    $response->setMaxAge(3600*24*30);
    return $response;
});

$app->get('/api', function () use ($app) {
    $response = new Response;
    $content = $app['cache']->get('api');
    if (!$content) {
        $content = json_encode($app['dgt']->getContent());
        $app['cache']->set('api', $content);
        $app['cache']->expire('api', 250);
    }
    $response->setContent($content);
    $response->setPublic();
    $date = new DateTime();
    $date->modify('+300 seconds');
    $response->setExpires($date);
    $response->setMaxAge(300);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
});
