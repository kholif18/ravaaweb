<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/shop', 'Shop::index');
$routes->get('/detail', 'DetailProduct::index');
$routes->get('/about', 'About::index');

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Produk
    $routes->get('products', 'Products::index');
    $routes->get('products/create', 'Products::create');
    $routes->post('products/store', 'Products::store');
    $routes->get('products/edit/(:num)', 'Products::edit/$1');
    $routes->post('products/update/(:num)', 'Products::update/$1');
    $routes->get('products/delete/(:num)', 'Products::delete/$1');

    // Kategori
    $routes->get('categories', 'Categories::index');
    $routes->get('categories/create', 'Categories::create');
    $routes->post('categories/store', 'Categories::store');

    // User
    $routes->get('users', 'Users::index');
});
