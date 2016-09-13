<?php

use App\Register\ControllerRegister;
use App\Register\PlaceOrderRegister;
use Silex\Application;
use Silex\Provider\SerializerServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

$app = new Application([
    'app.version' => '1.0.0',
]);
$app->register(new ServiceControllerServiceProvider());
$app->register(new SerializerServiceProvider());

$app->register(new ControllerRegister());
$app->register(new PlaceOrderRegister());

return $app;
