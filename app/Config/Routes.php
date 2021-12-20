<?php

namespace Config;

use Faker\Factory;

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
$routes->setDefaultController('Home');
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
$routes->get('/', 'Welcome::index');
$routes->get('/post/(:segment)','Welcome::showPost/$1');
$routes->post('/like/(:segment)', 'Welcome::likeOrUnlike/$1');
$routes->post('/unlike/(:segment)', 'Welcome::likeOrUnlike/$1');

$routes->get('/allComment/(:segment)', 'Comment::getAllComment/$1');
$routes->post('/comment', 'Comment::addComment');
$routes->get('/countComment/(:segment)', 'Comment::countComment/$1');



$routes->get('/about','Welcome::about');
$routes->get('/contact', 'Welcome::contact');
$routes->post('/contact', 'Welcome::sendMail');

$routes->get('/login','AuthController::index');
$routes->post('/login', 'AuthController::login');

$routes->get('/signup', 'AuthController::signup');
$routes->post('/signup', 'AuthController::register');

$routes->post('/logout', 'AuthController::logout');
$routes->get('/user_message','AuthController::user_message');

$routes->group('', ['filter' => 'auth'],function ($routes) {
    $routes->get('/dashboard','Admin\Admin::index');

    $routes->group('',['filter' => 'admin'],function ($routes) {
        //users 
        $routes->get('users',                 'Admin\User::index');
        $routes->get('users/new',             'Admin\User::new');
        $routes->post('users',                'Admin\User::create');
        $routes->get('users/(:segment)/edit', 'Admin\User::edit/$1');
        $routes->post('users/update/(:segment)',      'Admin\User::update/$1');
        $routes->post('users/delete/(:segment)',   'Admin\User::delete/$1');

        //role
        $routes->get('roles',                 'Admin\Role::index');
        $routes->get('roles/new',             'Admin\Role::new');
        $routes->post('roles',                'Admin\Role::create');
        $routes->get('roles/(:segment)/edit', 'Admin\Role::edit/$1');
        $routes->post('roles/update/(:segment)',      'Admin\Role::update/$1');
        $routes->post('roles/delete/(:segment)',   'Admin\Role::delete/$1');

        //tag
        $routes->get('tags',                 'Admin\Tag::index');
        $routes->get('tags/new',             'Admin\Tag::new');
        $routes->post('tags',                'Admin\Tag::create');
        $routes->get('tags/(:segment)/edit', 'Admin\Tag::edit/$1');
        $routes->post('tags/update/(:segment)',      'Admin\Tag::update/$1');
        $routes->post('tags/delete/(:segment)',   'Admin\Tag::delete/$1');
    });

    //post
    $routes->get('posts',                 'Admin\Post::index');
    $routes->get('posts/new',             'Admin\Post::new');
    $routes->post('posts',                'Admin\Post::create');
    $routes->get('posts/(:segment)/edit', 'Admin\Post::edit/$1');
    $routes->post('posts/update/(:segment)',      'Admin\Post::update/$1');
    $routes->post('posts/delete/(:segment)',   'Admin\Post::delete/$1');
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
