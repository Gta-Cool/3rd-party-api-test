<?php

namespace App\Register;

use App\Builder\ApiResponseBuilder;
use App\Builder\PostBuilder;
use App\Builder\UserBuilder;
use App\Handler\FavoritePostsHandler;
use App\Provider\FavoritePostsProvider;
use App\Resolver\ErrorMessageResolver;
use App\Serializer\PostNormalizer;
use App\Serializer\UserNormalizer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Serializer\Serializer;

class ServiceRegister implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $this->registerBuilder($app);
        $this->registerSerializer($app);

        $app['app.provider.favorite_posts'] = function() use ($app) {
            return new FavoritePostsProvider($app['app.favorite_post_ids'], $app['validator']);
        };

        $app['app.handler.favorite_posts'] = function() use ($app) {
            return new FavoritePostsHandler(
                $app['place_holder.repository.post'],
                $app['place_holder.repository.user'],
                $app['app.builder.post']
            );
        };

        $app['app.resolver.error_message'] = function() use ($app) {
            return new ErrorMessageResolver();
        };
    }

    /**
     * @param Container $app
     */
    protected function registerBuilder(Container $app)
    {
        $app['app.builder.user'] = function() use ($app) {
            return new UserBuilder();
        };

        $app['app.builder.post'] = function() use ($app) {
            return new PostBuilder($app['app.builder.user']);
        };

        $app['app.builder.api_response'] = function() use ($app) {
            return new ApiResponseBuilder($app['app.serializer'], $app['app.resolver.error_message']);
        };
    }

    /**
     * @param Container $app
     */
    protected function registerSerializer(Container $app)
    {
        $app['app.serializer.post_normalizer'] = function() use ($app) {
            return new PostNormalizer();
        };

        $app['app.serializer.user_normalizer'] = function() use ($app) {
            return new UserNormalizer();
        };

        $app['app.serializer'] = function ($app) {
            $normalizers = array_merge([
                $app['app.serializer.post_normalizer'],
                $app['app.serializer.user_normalizer'],
            ], $app['serializer.normalizers']);

            return new Serializer($normalizers, $app['serializer.encoders']);
        };
    }
}
