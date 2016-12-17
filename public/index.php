<?php


use App\Support\Container;


/** @var Container $app */
$app = require_once realpath(__DIR__ . '/../bootstrap/app.php');

$app->run('app/http/routes.php');