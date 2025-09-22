<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/shop', 'Shop::index');
$routes->get('/detail', 'DetailProduct::index');
$routes->get('/about', 'About::index');
