<?php

use Silex\Application;
use Silex\Provider\SerializerServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

$app = new Application([
    'app.version' => '1.0.0',
]);
$app->register(new ServiceControllerServiceProvider());
$app->register(new SerializerServiceProvider());


$app['app.controller.favorite_posts'] = function() use ($app) {
    return new \App\Controller\FavoritePostsController();
};

$app['place_order.client.guzzle'] = function() use ($app) {
    return new \GuzzleHttp\Client([
        'base_uri' => $app['place_order.client.param.base_url'],
    ]);
};

$app['place_order.serializer.posts_denormalizer'] = function() use ($app) {
    return new \PlaceOrder\Serializer\PostsDenormalizer();
};

$app['place_order.serializer.users_denormalizer'] = function() use ($app) {
    return new \PlaceOrder\Serializer\UsersDenormalizer();
};

$app['place_order.serializer'] = function ($app) {
    $normalizers = array_merge([
        $app['place_order.serializer.posts_denormalizer'],
        $app['place_order.serializer.users_denormalizer'],
    ], $app['serializer.normalizers']);

    return new \Symfony\Component\Serializer\Serializer($normalizers, $app['serializer.encoders']);
};

$app['place_order.client.http'] = function() use ($app) {
    return new \PlaceOrder\Client\Http\Client($app['place_order.client.guzzle'], $app['place_order.serializer']);
};

return $app;
