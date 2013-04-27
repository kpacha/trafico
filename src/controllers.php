<?php

$app->get('/', function () use ($app) {
    return $app['twig']->render('map.twig', array('google_api_key' => $app['parameters']['google.api.key']));
});

$app->get('/api', function () use ($app) {
    return $app->json($app['dgt']->getContent());
});
