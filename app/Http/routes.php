<?php

/**
 * @var \League\Route\RouteCollection $routes
 */
$route->addRoute('GET', '/', function() {
    return 'asdf';
});

$route->addRoute('GET', '/ajax', function() {
    return ['foo' => 'bar'];
});