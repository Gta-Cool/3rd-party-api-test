<?php

use Monolog\Logger;
use Silex\Provider\HttpCacheServiceProvider;

$app->register(new HttpCacheServiceProvider(), array(
    'http_cache.cache_dir' => __DIR__.'/../var/cache/http_cache',
));

// configure your app for the production environment

$app['monolog.logfile'] = __DIR__.'/../var/logs/prod.log';
$app['monolog.level'] = Logger::WARNING;

$app['place_holder.client.param.base_url'] = 'https://jsonplaceholder.typicode.com';
$app['place_holder.client.param.filesystem_cache_directory'] = __DIR__.'/../var/cache/place_holder_client';
$app['app.favorite_post_ids'] = [35, 48, 91, 150];
