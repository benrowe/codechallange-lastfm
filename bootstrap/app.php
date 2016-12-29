<?php

use App\Exceptions\RuntimeException;
use App\Support\Container;
use Doctrine\Common\Cache\FilesystemCache;
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
$app->share('cache', function () use ($app) {
    $config = $app->get('config');
    switch ($config->get('cache.driver')) {
        case 'file':
            return new FilesystemCache($config->get('cache.drivers.file.path'));
            break;
        default:
            throw new RuntimeException(sprintf('Cache engine %s is not supported by the application', $config->get('cache.engine')));
    }
});

$app->add('lastfm', function () use ($app) {
    return \App\Services\LastFm\Factory::fromConfigWithCaching($app->get('config')->get('lastfm'), $app->get('cache'));
});
//endregion

return $app;
