<?php

use App\Support\Container;
use League\Container\Container as DiContainer;
use Philo\Blade\Blade;

require_once __DIR__.'/../vendor/autoload.php';

// load environment
try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new Container(new DiContainer(), realpath(__DIR__.'/../'));

//region low level application services
$app->add('request', function () {
    return Symfony\Component\HttpFoundation\Request::createFromGlobals();
});
$app->share('response', \Symfony\Component\HttpFoundation\Response::class);
$app->share('emitter', Zend\Diactoros\Response\SapiEmitter::class);

$app->share('config', function () use ($app) {
    return new \Config\Repository(new \Config\Loader\FileLoader(\App\path('config')), getenv('APP_ENV'));
});

$app->share('view', function () use ($app) {
    return new Blade($app->get('config')->get('view.path'), $app->get('config')->get('view.cache'));
});
//endregion

//region general application services
$app->add('lastfm', function () {
    return new \App\Services\LastFm\Client(getenv('LASTFM_KEY'), getenv('LASTFM_SECRET'));
});
//endregion

return $app;
