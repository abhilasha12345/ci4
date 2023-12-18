<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'crud::index');

$routes->get('/crud', 'crud::index');
$routes->get('/crud/add', 'crud::add');
$routes->post('/crud/add_validation', 'crud::add_validation');
$routes->post('/crud/edit_validation', 'crud::edit_validation');
$routes->get('/crud/fetch_single_data/(:num)', 'crud::fetch_single_data/$1');
$routes->get('/crud/delete/(:num)', 'crud::delete/$1');
$routes->get('/crud/export', 'crud::export');
$routes->get('/crud/download_pdf', 'crud::download_pdf');

$routes->get('/crud/reject', 'crud::reject');
