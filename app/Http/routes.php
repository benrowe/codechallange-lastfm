<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\DefaultController;

/**
 * @var \League\Route\RouteCollection $route
 */
$route->addRoute('GET', '/', DefaultController::class.'::index');
