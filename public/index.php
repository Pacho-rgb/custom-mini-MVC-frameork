<?php

// This is the entry script.
// It handles all the requests and returns the corresponding responses
require_once __DIR__.'/../vendor/autoload.php';

use app\controllers\ProductController; 
use app\Router;

$router = new Router;

//  [ProductController::class, 'index'] -> This form takes the 'index' method from the ProductController class
// This is all possible combination of requests to our website/app
// The parameters will the be stored in arrays found in the Router class
$router->get('/', [ProductController::class, 'index']);
$router->get('/products', [ProductController::class, 'index']);
$router->get('/products/create', [ProductController::class, 'create']);
$router->get('/products/update', [ProductController::class, 'update']);
$router->post('/products/create', [ProductController::class, 'create']);
$router->post('/products/update', [ProductController::class, 'update']);
$router->post('/products/delete', [ProductController::class, 'delete']);

// Detects what is the current route, and will execute the corresponding function.  
$router->resolve(); 