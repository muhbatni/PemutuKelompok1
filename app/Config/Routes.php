<?php

use App\Controllers\Akreditasi;
use App\Controllers\ManajemenSurvey;
use App\Controllers\DashboardPeriode;
use App\Controllers\DokumenPenetapan;
use App\Controllers\InputDataPemutu;
use App\Controllers\InstrumenPemutu;
use App\Controllers\IsiSurvey;
use App\Controllers\KriteriaAkreditasi;
use App\Controllers\Login;
use App\Controllers\Profile;
use App\Controllers\Registrasi;
use App\Controllers\SyaratUnggul;
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
use App\Controllers\Periode;
use App\Controllers\Temuan;
use App\Controllers\InputTemuan;
use App\Controllers\Unit;
use App\Controllers\Lembaga;

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
  $routes->post('profile/reset-password', [Profile::class, 'reset_password']);

  $routes->get('survey', [SurveyKepuasan::class, 'index']);
  $routes->get('survey/manajemen-survey', [ManajemenSurvey::class, 'index']);
  $routes->match(['get', 'post'], 'survey/manajemen-survey/create', [ManajemenSurvey::class, 'createSurvey']);
  $routes->match(['get', 'post'], 'survey/manajemen-survey/edit/(:num)', [ManajemenSurvey::class, 'editSurvey/$1']);
  $routes->get('survey/isi-survey', [IsiSurvey::class, 'index']);

  $routes->get('audit/input-auditor', [InputAuditor::class, 'index']);
  $routes->get('audit/standar', [StandarAudit::class, 'index']);
  $routes->get('audit/input-standar', [InputStandarAudit::class, 'index']);
  $routes->get('audit/pelaksanaan', [PelaksanaanAudit::class, 'index']);
  $routes->match(['get','post'],'audit/input-pelaksanaan', [InputPelaksanaanAudit::class, 'index']);
  $routes->get('audit/data-dukung', [DataDukung::class, 'index']);
  $routes->get('audit/temuan', [Temuan::class, 'index']);
  $routes->get('audit/input-temuan', [InputTemuan::class, 'index']);

  $routes->get('akreditasi', [Akreditasi::class, 'index']);
  $routes->get('akreditasi/dashboard-periode', [DashboardPeriode::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/dokumen-penetapan', [DokumenPenetapan::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/kriteria', [KriteriaAkreditasi::class, 'index']);
  $routes->get('akreditasi/syarat-unggul', [SyaratUnggul::class, 'index']);
  // $routes->get('akreditasi/instrumen-pemutu', [InstrumenPemutu::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/instrumen-pemutu', [InstrumenPemutu::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/periode', [Periode::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/unit', [Unit::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/lembaga', [Lembaga::class, 'index']);
  $routes->get('akreditasi/input-data-pemutu', [InputDataPemutu::class, 'index']);
  //manajemen-akreditasi
  $routes->match(['GET', 'POST'], 'akreditasi', [Akreditasi::class, 'index']);
});

$routes->setAutoRoute(true);
?>
