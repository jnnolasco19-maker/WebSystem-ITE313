<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'auth::dashboard');
$routes->get('/login', 'auth::login');
$routes->post('/login', 'auth::login');
$routes->get('/register', 'auth::register');
$routes->post('/register', 'auth::register');
$routes->get('/dashboard', 'auth::dashboard');
$routes->get('/logout', 'auth::logout');
$routes->get('/restricted', 'Home::restricted');

// Legacy user routes (redirect to admin)
$routes->get('/users', 'UserController::index');
$routes->get('/users/edit/(:num)', 'UserController::edit/$1');
$routes->post('/users/update', 'UserController::update');
$routes->post('/users/create', 'UserController::create');

// Admin Routes
$routes->group('admin', function($routes) {
    $routes->get('/', 'AdminController::dashboard');
    $routes->get('dashboard', 'AdminController::dashboard');
    
    // User Management
    $routes->get('users', 'AdminController::users');
    $routes->get('users/edit/(:num)', 'AdminController::editUser/$1');
    $routes->post('users/update', 'AdminController::updateUser');
    $routes->post('users/create', 'AdminController::createUser');
    $routes->post('users/delete/(:num)', 'AdminController::deleteUser/$1');
    
    // Course Management
    $routes->get('courses', 'AdminController::courses');
    $routes->get('courses/edit/(:num)', 'AdminController::editCourse/$1');
    $routes->post('courses/create', 'AdminController::createCourse');
    $routes->post('courses/update', 'AdminController::updateCourse');
    $routes->post('courses/delete/(:num)', 'AdminController::deleteCourse/$1');
    $routes->post('courses/restore/(:num)', 'AdminController::restoreCourse/$1');
});

// Course enrollment route
$routes->post('/course/enroll', 'Course::enroll');

// Student Routes
$routes->group('student', function($routes) {
    $routes->get('/', 'StudentController::dashboard');
    $routes->get('dashboard', 'StudentController::dashboard');
    $routes->get('my-courses', 'StudentController::myCourses');
    $routes->get('browse', 'StudentController::browseCourses');
    $routes->get('profile', 'StudentController::profile');
    $routes->post('profile/update', 'StudentController::updateProfile');
    $routes->post('unenroll/(:num)', 'StudentController::unenroll/$1');
});

// Instructor Routes
$routes->group('instructor', function($routes) {
    $routes->get('/', 'InstructorController::dashboard');
    $routes->get('dashboard', 'InstructorController::dashboard');
    $routes->get('my-courses', 'InstructorController::myCourses');
    $routes->get('my-courses/edit/(:num)', 'InstructorController::editCourse/$1');
    $routes->post('courses/create', 'InstructorController::createCourse');
    $routes->post('courses/update', 'InstructorController::updateCourse');
    $routes->post('courses/delete/(:num)', 'InstructorController::deleteCourse/$1');
    $routes->get('students', 'InstructorController::students');
    $routes->get('profile', 'InstructorController::profile');
    $routes->post('profile/update', 'InstructorController::updateProfile');
});


