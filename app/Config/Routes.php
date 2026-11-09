<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
// $routes->get('dbtest', 'DbTest::index');
// $routes->get('analytics', 'Analytics::index');
// $routes->get('analytics/create', 'Analytics::create');
// $routes->post('analytics/store', 'Analytics::store');
// $routes->get('analytics/edit/(:num)', 'Analytics::edit/$1');
// $routes->post('analytics/update/(:num)', 'Analytics::update/$1');
// $routes->post('analytics/delete/(:num)', 'Analytics::delete/$1');
$routes->get('categories', 'Categories::index');
$routes->get('categories/create', 'Categories::create');
$routes->post('categories/store', 'Categories::store');
$routes->get('categories/edit/(:num)', 'Categories::edit/$1');
$routes->post('categories/update/(:num)', 'Categories::update/$1');
$routes->post('categories/delete/(:num)', 'Categories::delete/$1');