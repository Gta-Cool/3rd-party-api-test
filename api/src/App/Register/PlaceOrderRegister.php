<?php

namespace App\Register;

use GuzzleHttp\Client as GuzzleClient;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use PlaceOrder\Client\Http\Client;
use PlaceOrder\Serializer\PostsDenormalizer;
use PlaceOrder\Serializer\UsersDenormalizer;
use Symfony\Component\Serializer\Serializer;

class PlaceOrderRegister implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['place_order.client.guzzle'] = function() use ($app) {
            return new GuzzleClient([
                'base_uri' => $app['place_order.client.param.base_url'],
            ]);
        };

        $app['place_order.serializer.posts_denormalizer'] = function() use ($app) {
            return new PostsDenormalizer();
        };

        $app['place_order.serializer.users_denormalizer'] = function() use ($app) {
            return new UsersDenormalizer();
        };

        $app['place_order.serializer'] = function ($app) {
            $normalizers = array_merge([
                $app['place_order.serializer.posts_denormalizer'],
                $app['place_order.serializer.users_denormalizer'],
            ], $app['serializer.normalizers']);

            return new Serializer($normalizers, $app['serializer.encoders']);
        };

        $app['place_order.client.http'] = function() use ($app) {
            return new Client($app['place_order.client.guzzle'], $app['place_order.serializer']);
        };
    }
}
