<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('lista', 'TesteController::lista');
$routes->get('posts', 'TesteController::index');
$routes->get('posts/new', 'TesteController::new');
$routes->post('posts', 'TesteController::create');
$routes->get('posts/(:num)', 'TesteController::show/$1');
$routes->get('posts/edit/(:num)', 'TesteController::edit/$1');
$routes->put('posts/(:num)', 'TesteController::update/$1');
$routes->delete('posts/(:num)', 'TesteController::delete/$1');


$routes->get('/', 'HomeController::index');

$routes->group('home', function ($routes) {
    $routes->get('/', 'HomeController::index');
    $routes->get('index', 'HomeController::index');
    #$routes->match(['get', 'post'], 'login', 'HomeController::index');
    $routes->post('login', 'HomeController::login');
    $routes->get('logout', 'HomeController::logout');
});

$routes->group('admin', function ($routes) {
    $routes->add('/', 'AdminController::index');
    $routes->get('find_user', 'AdminController::find_user');
    $routes->post('get_user', 'AdminController::get_user');
    #$routes->match(['get', 'post'], 'get_user', 'AdminController::get_user');
    $routes->get('get_user/(:any)', 'AdminController::get_user/$1');
    $routes->post('import_user', 'AdminController::import_user');
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
