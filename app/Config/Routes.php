<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
 $routes->setAutoRoute(true);

$routes->get('/', 'Home::index');
$routes->get('home/page/(:segment)', 'Home::page/$1');
$routes->get('home/blog/(:segment)', 'Home::blog/$1');
