<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Client\ClientController::index');
$routes->get('dashboard', 'Admin\DashboardController::index');
$routes->get('login', 'Auth\LoginController::index');
$routes->get('forgotPassword', 'Auth\LoginController::forgotPassword');
$routes->get('register', 'Auth\LoginController::register');
