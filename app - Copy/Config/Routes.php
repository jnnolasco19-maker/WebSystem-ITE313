<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index'); // Homepage
$routes->get('/about', 'Home::about');  // About page
$routes->get('/contact', 'Home::contact'); // Contact page

$routes->get('/register', 'Auth::register');

$routes->post('/register', 'Auth::register');

$routes->get('/login', 'Auth::login');

$routes->post('/login', 'Auth::login');

$routes->get('/logout', 'Auth::logout');

$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('student/dashboard', 'Auth::studentDashboard');
$routes->get('teacher/dashboard', 'Auth::teacherDashboard');
$routes->get('admin/dashboard', 'Auth::adminDashboard');
$routes->get('/admin/courses', 'Admin::coursesList');
$routes->get('/student/courses', 'Auth::studentCourses');

$routes->get('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->post('/admin/course/(:num)/upload', 'Materials::upload/$1');
$routes->get('/admin/course/(:num)/materials', 'Materials::list/$1');
$routes->get('/materials/delete/(:num)', 'Materials::delete/$1');
$routes->get('/materials/download/(:num)', 'Materials::download/$1');

$routes->post('/course/enroll', 'Course::enroll');

// Course search routes
$routes->get('/courses/search', 'Course::search');
$routes->post('/courses/search', 'Course::search');

// Notifications API
$routes->get('/notifications', 'Notifications::get');
$routes->post('/notifications/mark_read/(:num)', 'Notifications::mark_as_read/$1');

