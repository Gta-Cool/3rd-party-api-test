<?php

use App\Exception\ApiHttpExceptionInterface;
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
    if ($app['debug']) {
        // if debug we rethrow the exception to take advantage of silex web-profiler
        throw $e;
    }

    if ($e instanceof ApiHttpExceptionInterface) {
        return $app['app.builder.api_response']->buildApiHttpExceptionResponse($e);
    }

    return $app['app.builder.api_response']->buildErrorResponse($code);
});
