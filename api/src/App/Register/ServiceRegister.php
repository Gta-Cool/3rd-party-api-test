<?php

namespace App\Register;

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
    }
}
