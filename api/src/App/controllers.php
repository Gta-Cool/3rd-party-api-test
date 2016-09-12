<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


$app['favorite_posts.controller'] = function() use ($app) {
    return new \App\Controller\FavoritePostsController();
};

$app->get('/', function () use ($app) {
        return new JsonResponse([
            'version' => '1.0.0',
        ]);
    })
    ->bind('info_api')
;

$app->get('/favorite_posts', 'favorite_posts.controller:listAction')->bind('favorite_posts_list_api');

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    $data = [
        'message' => 'An error occurred.',
        'code' => $code,
    ];

    if ($app['debug']) {
        $data['message'] = $e->getMessage();
    }

    return new JsonResponse($data);
});
