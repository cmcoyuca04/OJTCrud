<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('categories', 'Categories::index');
$routes->get('categories/create', 'Categories::create');
$routes->post('categories/store', 'Categories::store');
$routes->get('categories/edit/(:num)', 'Categories::edit/$1');
$routes->post('categories/update/(:num)', 'Categories::update/$1');
$routes->post('categories/delete/(:num)', 'Categories::delete/$1');

// Employees CRUD (test_database.employees)
// The csrf filter rejects any POST that doesn't carry the token from csrf_field().
$routes->group('employees', ['filter' => 'csrf'], static function ($routes) {
    $routes->get('/', 'Employees::index');
    $routes->get('create', 'Employees::create');
    $routes->post('store', 'Employees::store');
    $routes->get('edit/(:num)', 'Employees::edit/$1');
    $routes->post('update/(:num)', 'Employees::update/$1');
    $routes->post('delete/(:num)', 'Employees::delete/$1');
});