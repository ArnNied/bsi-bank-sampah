<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Dashboard::index');
$routes->group('auth', function ($routes) {
    $routes->get('', 'Auth::login');
    $routes->match(['get', 'post'], 'login', 'Auth::login');
    $routes->post('logout', 'Auth::logout');
});
$routes->group('kategori', function ($routes) {
    $routes->get('', 'Kategori::index');
    $routes->match(['get', 'post'], 'tambah', 'Kategori::tambah');
    $routes->match(['get', 'post'], 'ubah/(:num)', 'Kategori::ubah/$1');
    $routes->post('hapus/(:num)', 'Kategori::hapus/$1');
});
$routes->group('nasabah', function ($routes) {
    $routes->get('', 'Nasabah::index');
    $routes->match(['get', 'post'], 'tambah', 'Nasabah::tambah');
    $routes->match(['get', 'post'], 'ubah/(:num)', 'Nasabah::ubah/$1');
    $routes->post('ubah/(:num)/ganti-password', 'Nasabah::ganti_password/$1');
    $routes->post('hapus/(:num)', 'Nasabah::hapus/$1');
});
$routes->group('teller', function ($routes) {
    $routes->get('', 'Teller::index');
    $routes->match(['get', 'post'], 'tambah', 'Teller::tambah');
    $routes->match(['get', 'post'], 'ubah/(:num)', 'Teller::ubah/$1');
    $routes->post('ubah/(:num)/ganti-password', 'Teller::ganti_password/$1');
    $routes->post('hapus/(:num)', 'Teller::hapus/$1');
});
$routes->group('setoran', function ($routes) {
    $routes->get('', 'Setoran::index');
    $routes->match(['get', 'post'], 'tambah', 'Setoran::tambah');
    $routes->post('hapus/(:num)', 'Setoran::hapus/$1');
    $routes->get('export/(:alpha)', 'Setoran::export/$1');
});
$routes->group('penarikan', function ($routes) {
    $routes->get('', 'Penarikan::index');
    $routes->match(['get', 'post'], 'tambah', 'Penarikan::tambah');
    $routes->post('hapus/(:num)', 'Penarikan::hapus/$1');
    $routes->get('export/(:alpha)', 'Penarikan::export/$1');
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
