<?php

namespace App\Register;

use GuzzleHttp\Client as GuzzleClient;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use PlaceOrder\Client\Http\Client;
use PlaceOrder\Factory\RepositoryFactory;
use PlaceOrder\Serializer\PostsDenormalizer;
use PlaceOrder\Serializer\UsersDenormalizer;
use Symfony\Component\Serializer\Serializer;

class PlaceOrderRegister implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $this->registerClient($app);
        $this->registerRepository($app);
        $this->registerSerializer($app);
    }

    /**
     * @param Container $app
     */
    protected function registerClient(Container $app)
    {
        $app['place_order.client.guzzle'] = function() use ($app) {
            return new GuzzleClient([
                'base_uri' => $app['place_order.client.param.base_url'],
            ]);
        };

        $app['place_order.client.http'] = function() use ($app) {
            return new Client($app['place_order.client.guzzle'], $app['place_order.serializer']);
        };
    }

    /**
     * @param Container $app
     */
    protected function registerRepository(Container $app)
    {
        $app['place_order.factory.repository'] = function() use ($app) {
            return new RepositoryFactory($app['place_order.client.http'], $app['place_order.serializer']);
        };

        $app['place_order.repository.post'] = function() use ($app) {
            /** @var RepositoryFactory $repositoryFactory */
            $repositoryFactory = $app['place_order.factory.repository'];

            return $repositoryFactory->getByName('post');
        };

        $app['place_order.repository.user'] = function() use ($app) {
            /** @var RepositoryFactory $repositoryFactory */
            $repositoryFactory = $app['place_order.factory.repository'];

            return $repositoryFactory->getByName('user');
        };
    }

    /**
     * @param Container $app
     */
    protected function registerSerializer(Container $app)
    {
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
    }
}
