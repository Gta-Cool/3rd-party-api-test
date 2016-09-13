<?php

use App\Exception\ViolationsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

$app->get('/', function () use ($app) {
        return new JsonResponse([
            'version' => $app['app.version'],
        ]);
    })
    ->bind('info_api')
;

$app->get('/favorite_posts', 'app.controller.favorite_posts:listAction')->bind('favorite_posts_list_api');

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($e instanceof ViolationsException) {
        return new JsonResponse([
            'code' => JsonResponse::HTTP_BAD_REQUEST,
            'errors' => $e->getViolationsAsArray(),
        ], JsonResponse::HTTP_BAD_REQUEST);
    }

    if ($app['debug']) {
        // if debug we rethrow the exception to take advantage of silex web-profiler
        throw $e;
    }

    return new JsonResponse([
        'code' => $code,
        'message' => 'An error occurred.',
    ], $code);
});
