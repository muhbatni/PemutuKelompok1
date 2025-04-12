<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('registrasi', 'Registrasi::index');
$routes->post('registrasi', 'Auth::register');

$routes->get('login', 'Login::index');
$routes->post('login', 'Auth::login');

$routes->get('auth/logout', 'Auth::logout');

$routes->get("survey-kepuasan", "SurveyKepuasan::index");

$routes->group('', ['filter' => 'auth'], function ($routes) {
  $routes->get('/', 'Dashboard::index');
  $routes->get('dashboard', 'Dashboard::index');
  $routes->get('survey-kepuasan', 'SurveyKepuasan::index');
});
$routes->setAutoRoute(true);
