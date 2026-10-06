<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing page
$routes->get('/', 'Pages::landing');

// About page
$routes->get('about', 'Pages::about');

// Customer Accounts page (data comes from the customers table via CustomerModel)
$routes->get('customers', 'Customers::index');

// User Accounts page (data comes from the users table via UserModel)
$routes->get('users', 'Users::index');
