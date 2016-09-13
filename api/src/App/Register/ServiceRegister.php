<?php

namespace App\Register;

use App\Builder\PostBuilder;
use App\Builder\UserBuilder;
use App\Handler\FavoritePostsHandler;
use App\Provider\FavoritePostIdsProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceRegister implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['app.provider.favorite_post_ids'] = function() use ($app) {
            return new FavoritePostIdsProvider($app['app.favorite_post_ids']);
        };

        $app['app.handler.favorite_posts'] = function() use ($app) {
            return new FavoritePostsHandler(
                $app['place_order.repository.post'],
                $app['place_order.repository.user'],
                $app['app.builder.post']
            );
        };

        $app['app.builder.user'] = function() use ($app) {
            return new UserBuilder();
        };

        $app['app.builder.post'] = function() use ($app) {
            return new PostBuilder($app['app.builder.user']);
        };
    }
}
