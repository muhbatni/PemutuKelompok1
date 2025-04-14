<?php

use App\Controllers\Login;
use App\Controllers\Registrasi;
use CodeIgniter\Router\RouteCollection;

use App\Controllers\Auth;
use App\Controllers\Dashboard;
use App\Controllers\SurveyKepuasan;

/**
 * @var RouteCollection $routes
 */

$routes->get('registrasi', [Registrasi::class, 'index']);
$routes->post('registrasi', [Auth::class, 'register']);

$routes->get('login', [Login::class, 'index']);
$routes->post('login', [Auth::class, 'login']);

$routes->get('auth/logout', [Auth::class, 'logout']);

$routes->group('', ['filter' => 'auth'], function ($routes) {
  $routes->get('/', [Dashboard::class, 'index']);
  $routes->get('dashboard', [Dashboard::class, 'index']);
  $routes->get('survey-kepuasan', [SurveyKepuasan::class, 'index']);
});
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get("/survey-kepuasan", "SurveyKepuasan::index");
$routes->get("/kriteria-akreditasi", "KriteriaAkreditasi::index");
$routes->get("/syarat-unggul", "SyaratUnggul::index");
$routes->get("/instrumen-pemutu", "InstrumenPemutu::index");
$routes->get("/akreditasi", "Akreditasi::index");
$routes->get("/periode", "Periode::index");
$routes->get("/input-datapemutu", "InputDataPemutu::index");
$routes->get("/dokumen-penetapan", "DokumenPenetapan::index");
$routes->get("/dashboard", "Dashboard::index");
$routes->setAutoRoute(true);
