<?php

use App\Support\Container;
use League\Container\Container as DiContainer;

require_once __DIR__.'/../vendor/autoload.php';

// load environment
try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new Container(new DiContainer(), realpath(__DIR__.'/../'));

//region application services
$app->add('request', function () {
    return Symfony\Component\HttpFoundation\Request::createFromGlobals();
});
$app->share('response', \Symfony\Component\HttpFoundation\Response::class);;
$app->share('emitter', Zend\Diactoros\Response\SapiEmitter::class);

$app->share('config', function() use ($app) {

    return new \Config\Repository(new \Config\Loader\FileLoader(__DIR__.'/config'), getenv('APP_ENV'));
});
//endregion

return $app;