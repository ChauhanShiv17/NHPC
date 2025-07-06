<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

$routes->get('/', 'HomeController::index');         // ✅ For homepage
$routes->get('/blog', 'BlogController::index');     // ✅ For published blogs
$routes->get('/home', 'HomeController::index');





$routes->get('/login', 'AuthController::login');
$routes->post('/do-login', 'AuthController::doLogin');
$routes->get('/logout', 'AuthController::logout');
$routes->get('admin/dashboard', 'Admin\Dashboard::index');
$routes->get('author/dashboard', 'Author\Dashboard::index');
$routes->get('/blog/create', 'BlogController::create');
$routes->post('/blog/store', 'BlogController::store');
$routes->get('/admin/dashboard', 'AdminController::dashboard');
$routes->get('/admin', 'AdminController::index');
$routes->get('/admin/approve/(:num)', 'AdminController::approve/$1');
$routes->get('/admin/reject/(:num)', 'AdminController::reject/$1');
$routes->get('category/(:any)', 'BlogController::category/$1');
$routes->get('blog/(:num)', 'BlogController::view/$1');
$routes->get('category/(:any)', 'HomeController::category/$1');
$routes->post('/login', 'AuthController::doLogin');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::doRegister');
$routes->get('/', 'HomeController::index'); // homepage redirects to login if not logged in
$routes->get('/my-profile', 'ProfileController::index');
$routes->get('/admin/analytics', 'Admin\Analytics::index');
$routes->get('/profile', 'UserController::profile');





$routes->get('/home', function() {
    return view('home');
});

