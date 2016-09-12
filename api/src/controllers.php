<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

$app->get('/', function () use ($app) {
        return new JsonResponse([
            'version' => '1.0.0',
        ]);
    })
    ->bind('info_api')
;

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
