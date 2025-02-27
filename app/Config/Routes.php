<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home/getmhsmatkulv1', 'Home::getmhsmatkulv1');
$routes->get('/home/getmhsmatkulv2', 'Home::getmhsmatkulv2');
$routes->post('/home/simpansingle', 'Home::simpansingle');
$routes->post('/home/simpankolektif', 'Home::simpankolektif');
