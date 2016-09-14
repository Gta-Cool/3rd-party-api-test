<?php

use Silex\Provider\HttpCacheServiceProvider;

$app->register(new HttpCacheServiceProvider(), array(
    'http_cache.cache_dir' => __DIR__.'/../var/cache/http_cache',
));

// configure your app for the production environment

$app['place_holder.client.param.base_url'] = 'https://jsonplaceholder.typicode.com';
$app['app.favorite_post_ids'] = [35, 48, 91, 150];
