<?php

ini_set('display_errors', 0);

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/App/app.php';
require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/App/controllers.php';
$app['http_cache']->run();
