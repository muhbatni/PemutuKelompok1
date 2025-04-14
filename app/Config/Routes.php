<?php

use App\Controllers\Akreditasi;
use App\Controllers\DashboardPeriode;
use App\Controllers\DokumenPenetapan;
use App\Controllers\InputDataPemutu;
use App\Controllers\InstrumenPemutu;
use App\Controllers\KriteriaAkreditasi;
use App\Controllers\Login;
use App\Controllers\Periode;
use App\Controllers\Registrasi;
use App\Controllers\SyaratUnggul;
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
  $routes->get('/lembaga/dashboard', [DashboardPeriode::class, 'index']);
  $routes->get('/lembaga/dokumen-penetapan', [DokumenPenetapan::class, 'index']);
  $routes->get('/lembaga/kriteria-akreditasi', [KriteriaAkreditasi::class, 'index']);
  $routes->get('/lembaga/syarat-unggul', [SyaratUnggul::class, 'index']);
  $routes->get('/lembaga/instrumen-pemutu',  [InstrumenPemutu::class, 'index']);
  $routes->get('/lembaga/akreditasi',  [Akreditasi::class, 'index']);
  $routes->get('/lembaga/periode',  [Periode::class, 'index']);
  $routes->get('/lembaga/input-datapemutu',  [InputDataPemutu::class, 'index']);
});

$routes->setAutoRoute(true);
