<?php

namespace App\Register;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\Psr6CacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use PlaceHolder\Client\Http\Client;
use PlaceHolder\Factory\RepositoryFactory;
use PlaceHolder\Serializer\PostsDenormalizer;
use PlaceHolder\Serializer\UsersDenormalizer;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Serializer\Serializer;

class PlaceHolderRegister implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
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
        $app['place_holder.client.guzzle_cache_middleware'] = function() use ($app) {
            return new CacheMiddleware(
                new PrivateCacheStrategy(
                    new Psr6CacheStorage(
                        new FilesystemAdapter('guzzle', 0, $app['place_holder.client.param.filesystem_cache_directory'])
                    )
                )
            );
        };

        $app['place_holder.client.guzzle_handler'] = function() use ($app) {
            $handler = HandlerStack::create();
            $handler->push($app['place_holder.client.guzzle_cache_middleware'], 'cache');

            return $handler;
        };

        $app['place_holder.client.guzzle'] = function() use ($app) {
            return new GuzzleClient([
                'base_uri' => $app['place_holder.client.param.base_url'],
                'handler' => $app['place_holder.client.guzzle_handler'],
            ]);
        };

        $app['place_holder.client.http'] = function() use ($app) {
            return new Client($app['place_holder.client.guzzle'], $app['place_holder.serializer']);
        };
    }

    /**
     * @param Container $app
     */
    protected function registerRepository(Container $app)
    {
        $app['place_holder.factory.repository'] = function() use ($app) {
            return new RepositoryFactory($app['place_holder.client.http'], $app['place_holder.serializer']);
        };

        $app['place_holder.repository.post'] = function() use ($app) {
            /** @var RepositoryFactory $repositoryFactory */
            $repositoryFactory = $app['place_holder.factory.repository'];

            return $repositoryFactory->getByName('post');
        };

        $app['place_holder.repository.user'] = function() use ($app) {
            /** @var RepositoryFactory $repositoryFactory */
            $repositoryFactory = $app['place_holder.factory.repository'];

            return $repositoryFactory->getByName('user');
        };
    }

    /**
     * @param Container $app
     */
    protected function registerSerializer(Container $app)
    {
        $app['place_holder.serializer.posts_denormalizer'] = function() use ($app) {
            return new PostsDenormalizer();
        };

        $app['place_holder.serializer.users_denormalizer'] = function() use ($app) {
            return new UsersDenormalizer();
        };

        $app['place_holder.serializer'] = function ($app) {
            $normalizers = array_merge([
                $app['place_holder.serializer.posts_denormalizer'],
                $app['place_holder.serializer.users_denormalizer'],
            ], $app['serializer.normalizers']);

            return new Serializer($normalizers, $app['serializer.encoders']);
        };
    }
}
