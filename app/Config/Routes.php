<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->post('/login', 'HomeController::login');
$routes->get('products/', 'ProductController::index');
$routes->delete('products/delete/(:num)', 'ProductController::delete/$1');
$routes->put('products/edit/(:num)', 'ProductController::edit/$1');
