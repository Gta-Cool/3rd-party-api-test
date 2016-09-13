<?php

namespace App\Register;

use App\Controller\FavoritePostsController;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ControllerRegister implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['app.controller.favorite_posts'] = function() use ($app) {
            return new FavoritePostsController($app['app.provider.favorite_post_ids']);
        };
    }
}
