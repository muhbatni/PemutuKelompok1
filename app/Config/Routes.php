<?php

use App\Controllers\Login;
use App\Controllers\Profile;
use App\Controllers\Registrasi;
use CodeIgniter\Router\RouteCollection;

use App\Controllers\Auth;
use App\Controllers\Dashboard;
use App\Controllers\SurveyKepuasan;
use App\Controllers\InputAuditor;
use App\Controllers\StandarAudit;
use App\Controllers\PelaksanaanAudit;
use App\Controllers\InputStandarAudit;
use App\Controllers\InputPelaksanaanAudit;
use App\Controllers\DataDukung;

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
  $routes->get('profile', [Profile::class, 'index']);
  $routes->post('profile/edit', [Profile::class, 'edit']);
  // $routes->post('profile/reset-password', [Profile::class, 'reset_password']);
  $routes->get('survey-kepuasan', [SurveyKepuasan::class, 'index']);
  $routes->get('/input-auditor', [InputAuditor::class, 'index']);
  $routes->get('/standar-audit', [StandarAudit::class, 'index']);
  $routes->get('/input-standar-audit', [InputStandarAudit::class, 'index']);
  $routes->get('/pelaksanaan-audit', [PelaksanaanAudit::class, 'index']);
  $routes->get('/input-pelaksanaan-audit', [InputPelaksanaanAudit::class, 'index']);
  $routes->get('/data-dukung', [DataDukung::class, 'index']);
});
$routes->setAutoRoute(true);
?>

