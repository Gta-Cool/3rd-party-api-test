<?php

namespace App\Register;

use App\Controller\FavoritePostsController;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ControllerRegister implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['app.controller.favorite_posts'] = function() use ($app) {
            return new FavoritePostsController(
                $app['app.provider.favorite_posts'],
                $app['app.handler.favorite_posts'],
                $app['app.builder.api_response']
            );
        };
    }
}
