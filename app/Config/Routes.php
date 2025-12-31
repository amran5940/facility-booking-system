<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('/login', 'AuthController::doLogin');
$routes->post('/register', 'AuthController::doRegister');
$routes->get('/forgot-password', 'AuthController::forgotPassword');
$routes->post('/forgot-password', 'AuthController::doForgotPassword');
$routes->get('/logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
	$routes->get('/dashboard', 'DashboardController::index');
	$routes->get('/change-password', 'AuthController::changePassword');
	$routes->post('/change-password', 'AuthController::doChangePassword');
	$routes->post('/user/update-profile', 'AuthController::updateProfile');

	$routes->get('/admin', 'DashboardController::admin', ['filter' => 'role:admin']); // Alias
	$routes->get('/admin/dashboard', 'DashboardController::admin', ['filter' => 'role:admin']);
	$routes->get('/manager', 'DashboardController::manager', ['filter' => 'role:manager']);
	$routes->get('/user', 'DashboardController::user', ['filter' => 'role:user,manager,admin']);

	$routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
		$routes->get('agencies', 'AgenciesController::index');
		$routes->get('agencies/create', 'AgenciesController::createForm');
		$routes->post('agencies', 'AgenciesController::create');
		$routes->get('agencies/(:num)/edit', 'AgenciesController::edit/$1');
		$routes->post('agencies/(:num)/update', 'AgenciesController::update/$1');
		$routes->post('agencies/(:num)/delete', 'AgenciesController::delete/$1');
		$routes->post('agencies/(:num)/assign', 'AgenciesController::assignManager/$1');
		$routes->post('agencies/(:num)/unassign', 'AgenciesController::unassignManager/$1');
		$routes->post('managers', 'AgenciesController::createManager');
		$routes->get('managers', 'AgenciesController::listManagers');
		$routes->get('managers/(:num)/edit', 'AgenciesController::editManager/$1');
		$routes->post('managers/(:num)/update', 'AgenciesController::updateManager/$1');
		$routes->post('managers/(:num)/delete', 'AgenciesController::deleteManager/$1');

		$routes->get('users', 'UserController::index');
		$routes->get('users/create', 'UserController::create');
		$routes->post('users', 'UserController::store');
		$routes->get('users/(:num)/edit', 'UserController::edit/$1');
		$routes->post('users/(:num)/update', 'UserController::update/$1');
		$routes->post('users/(:num)/delete', 'UserController::delete/$1');
		$routes->post('users/(:num)/toggle-status', 'UserController::toggleStatus/$1');
		$routes->post('facility-categories', 'AgenciesController::createFacilityCategory');
		$routes->get('facility-categories', 'AgenciesController::listFacilityCategories');
		$routes->get('facility-categories/(:num)/edit', 'AgenciesController::editFacilityCategory/$1');
		$routes->post('facility-categories/(:num)/update', 'AgenciesController::updateFacilityCategory/$1');
		$routes->post('facility-categories/(:num)/delete', 'AgenciesController::deleteFacilityCategory/$1');
		$routes->get('facility-categories/(:num)/fields', 'AgenciesController::manageCategoryFields/$1');
		$routes->post('facility-categories/(:num)/fields', 'AgenciesController::addCategoryField/$1');
		$routes->get('facility-categories/fields/(:num)/delete', 'AgenciesController::deleteCategoryField/$1');
		$routes->get('facilities', 'FacilityController::adminIndex');
		$routes->get('facilities/(:num)/edit', 'FacilityController::edit/$1');
		$routes->post('facilities/(:num)/update', 'FacilityController::update/$1');
		$routes->post('facilities/(:num)/delete', 'FacilityController::delete/$1');
		$routes->get('bookings', 'BookingController::adminIndex');
		$routes->post('bookings/(:num)/approve', 'BookingController::approve/$1');
		$routes->post('bookings/(:num)/reject', 'BookingController::reject/$1');
		$routes->post('bookings/(:num)/delete', 'BookingController::delete/$1');
	});

	$routes->group('manager', ['filter' => 'role:manager'], static function ($routes) {
		$routes->get('dashboard', 'DashboardController::manager');
		$routes->get('facilities', 'FacilityController::index');
		$routes->get('facilities/create', 'FacilityController::create');
		$routes->post('facilities', 'FacilityController::store');
		$routes->get('facilities/(:num)/edit', 'FacilityController::edit/$1');
		$routes->post('facilities/(:num)/update', 'FacilityController::update/$1');
		$routes->post('facilities/(:num)/delete', 'FacilityController::delete/$1');
		$routes->get('facilities/(:num)/bookings', 'FacilityController::getBookings/$1');
		$routes->post('facilities/block-dates', 'FacilityController::blockDates');
		$routes->get('bookings', 'BookingController::managerIndex');
		$routes->post('unassign', 'DashboardController::unassignManager');
		$routes->post('bookings/(:num)/approve', 'BookingController::approve/$1');
		$routes->post('bookings/(:num)/reject', 'BookingController::reject/$1');
		$routes->post('bookings/(:num)/delete', 'BookingController::delete/$1');
		$routes->post('assign-user/(:num)', 'DashboardController::assignUserToAgency/$1');
	});

	$routes->group('user', ['filter' => 'role:user'], static function ($routes) {
		$routes->get('bookings', 'BookingController::index');
		$routes->get('bookings/create/(:num)', 'BookingController::create/$1');
		$routes->post('bookings', 'BookingController::store');
	});

});
