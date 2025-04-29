<?php

use App\Controllers\Akreditasi;
use App\Controllers\InputManajemenAudit;
use App\Controllers\ManajemenAudit;
use App\Controllers\ManajemenSurvey;
use App\Controllers\DashboardPeriode;
use App\Controllers\DokumenPenetapan;
use App\Controllers\InputDataPemutu;
use App\Controllers\InstrumenPemutu;
use App\Controllers\IsiSurvey;
use App\Controllers\KriteriaAkreditasi;
use App\Controllers\Login;
use App\Controllers\PelaksanaanAudit;
use App\Controllers\Profile;
use App\Controllers\Registrasi;
use App\Controllers\SyaratUnggul;
use CodeIgniter\Router\RouteCollection;

use App\Controllers\Auth;
use App\Controllers\Dashboard;
use App\Controllers\SurveyKepuasan;
use App\Controllers\InputAuditor;
use App\Controllers\StandarAudit;
use App\Controllers\Auditor;
use App\Controllers\InputStandarAudit;
use App\Controllers\DataDukung;
use App\Controllers\Periode;
use App\Controllers\Temuan;
use App\Controllers\InputTemuan;
use App\Controllers\IsianPemutu;
use App\Controllers\Unit;
use App\Controllers\Lembaga;
use App\Controllers\InputDataDukung;

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
  $routes->get('survey/manajemen-survey/delete/(:num)', [ManajemenSurvey::class, 'deleteSurvey/$1']);
  $routes->match(['get', 'post'], 'survey/manajemen-survey/create', [ManajemenSurvey::class, 'createSurvey']);
  $routes->match(['get', 'post'], 'survey/manajemen-survey/edit/(:num)', [ManajemenSurvey::class, 'editSurvey/$1']);
  $routes->get('survey/isi-survey', [IsiSurvey::class, 'index']);

  $routes->get('audit/auditor', [Auditor::class, 'index']);
  $routes->get('audit/input-auditor', [InputAuditor::class, 'index']);
  $routes->post('audit/input-auditor/simpan', [InputAuditor::class, 'simpan']);
  $routes->get('audit/standar', [StandarAudit::class, 'index']);
  $routes->match(['get', 'post'], 'audit/standar', 'StandarAudit::insert');
  $routes->get('audit/standar/edit/(:num)', 'StandarAudit::edit/$1');
  $routes->get('audit/standar/delete/(:num)', 'StandarAudit::delete/$1');
  $routes->get('audit/input-standar', [InputStandarAudit::class, 'index']);
  $routes->match(['get', 'post'], 'audit/input-standar', [InputStandarAudit::class, 'index']);
  $routes->get('audit/input-standar/edit/(:num)', [InputStandarAudit::class, 'edit/$1']);
  $routes->post('audit/input-standar/update/(:num)', [InputStandarAudit::class, 'update/$1']);
  $routes->get('audit/manajemen-audit', [ManajemenAudit::class, 'index']);
  $routes->match(['get', 'post'], 'audit/input-manajemen-audit', [InputManajemenAudit::class, 'index']);
  $routes->get('audit/input-manajemen-audit/edit/(:num)', 'InputManajemenAudit::edit/$1');
  $routes->post('audit/input-manajemen-audit/update/(:num)', 'InputManajemenAudit::update/$1');
  $routes->get('audit/input-manajemen-audit/delete/(:num)', 'InputManajemenAudit::delete/$1');
  $routes->get('audit/pelaksanaan-audit', [PelaksanaanAudit::class, 'index']);
  $routes->get('audit/pelaksanaan-audit/edit/(:num)', 'PelaksanaanAudit::edit/$1');
  $routes->get('audit/data-dukung', [DataDukung::class, 'index']);
  $routes->match(['get','post'],'audit/input-data-dukung', [InputDataDukung::class, 'index']);
  $routes->get('audit/input-data-dukung/edit/(:num)', [InputDataDukung::class, 'edit/$1']);
  $routes->post('audit/input-data-dukung/update/(:num)', [InputDataDukung::class, 'update/$1']);
  $routes->get('audit/get-pelaksanaan-info/(:num)', [InputDataDukung::class, 'getPelaksanaanInfo/$1']);
  $routes->get('audit/temuan', [Temuan::class, 'index']);
  $routes->get('audit/input-temuan', [InputTemuan::class, 'index']);

  $routes->get('akreditasi', [Akreditasi::class, 'index']);
  $routes->match(['GET', 'POST'], 'akreditasi', [Akreditasi::class, 'index']);
  $routes->get('akreditasi/dashboard-periode', [DashboardPeriode::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/dokumen-penetapan', [DokumenPenetapan::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/kriteria', [KriteriaAkreditasi::class, 'index']);
  $routes->get('akreditasi/syarat-unggul', [SyaratUnggul::class, 'index']);
  $routes->match(['GET', 'POST'], 'akreditasi/syarat-unggul', [SyaratUnggul::class, 'index']);
  // $routes->get('akreditasi/instrumen-pemutu', [InstrumenPemutu::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/instrumen-pemutu', [InstrumenPemutu::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/periode', [Periode::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/unit', [Unit::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/lembaga', [Lembaga::class, 'index']);
  $routes->get('akreditasi/input-data-pemutu', [InputDataPemutu::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/isian-pemutu', [IsianPemutu::class, 'index']);
});

$routes->setAutoRoute(true);
?>