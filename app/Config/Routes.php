<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->post('/login', 'HomeController::login');
$routes->get('products/', 'ProductController::index');
$routes->get('getProducts/', 'ProductController::getProducts');
$routes->post('products/create', 'ProductController::create');
$routes->delete('products/delete/(:num)', 'ProductController::delete/$1');
$routes->post('products/update', 'ProductController::update');
