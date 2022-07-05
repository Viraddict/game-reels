<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/helpers.php';

use Game\App\Application;
use Symfony\Component\HttpFoundation\Request;

$app = new Application();

$request = Request::createFromGlobals();

$response = $app->handle($request);

$response->send();
