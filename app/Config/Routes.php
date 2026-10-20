<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing page
$routes->get('/', 'Pages::landing');

// About page
$routes->get('about', 'Pages::about');

// Login and logout (public)
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->post('logout', 'Auth::logout');

// Everything inside this group needs a logged-in user. The 'auth' filter runs before every route
// below (the lists, the new/edit forms, AND the create/update handlers that receive the form data).
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Customer Accounts: list, create, edit (data comes from the customers table via CustomerModel)
    $routes->get('customers', 'Customers::index');
    $routes->get('customers/new', 'Customers::new');
    $routes->post('customers/create', 'Customers::create');
    $routes->get('customers/edit/(:num)', 'Customers::edit/$1');
    $routes->post('customers/update/(:num)', 'Customers::update/$1');

    // User Accounts: list, create, edit + avatar upload (data comes from the users table via UserModel)
    $routes->get('users', 'Users::index');
    $routes->get('users/new', 'Users::new');
    $routes->post('users/create', 'Users::create');
    $routes->get('users/edit/(:num)', 'Users::edit/$1');
    $routes->post('users/update/(:num)', 'Users::update/$1');
});
