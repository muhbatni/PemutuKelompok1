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

  $routes->get('survey', [ManajemenSurvey::class, 'index']);
  $routes->get('survey/delete', [ManajemenSurvey::class, 'deleteSurvey']);
  $routes->match(['GET', 'POST'], 'survey/create', [ManajemenSurvey::class, 'createSurvey']);
  $routes->match(['GET', 'POST'], 'survey/edit', [ManajemenSurvey::class, 'editSurvey']);
  $routes->get('isi-survey', [IsiSurvey::class, 'index']);
  $routes->match(['GET', 'POST'], 'isi-survey/(:segment)-(:num)', [IsiSurvey::class, 'isiSurvey/$1-$2']);
  $routes->get('survey/view', [ManajemenSurvey::class, 'viewSurvey']);

  $routes->get('audit/auditor', [Auditor::class, 'index']);
  $routes->get('audit/input-auditor', [InputAuditor::class, 'index']);
  $routes->post('audit/input-auditor/simpan', [InputAuditor::class, 'simpan']);
  $routes->get('audit/standar', [StandarAudit::class, 'index']);
  $routes->get('audit/input-standar', [InputStandarAudit::class, 'index']);
  $routes->get('audit/manajemen-audit', [ManajemenAudit::class, 'index']);
  $routes->match(['GET', 'POST'], 'audit/input-manajemen-audit', [InputManajemenAudit::class, 'index']);
  $routes->get('audit/input-manajemen-audit/edit/(:num)', 'InputManajemenAudit::edit/$1');
  $routes->post('audit/input-manajemen-audit/update/(:num)', 'InputManajemenAudit::update/$1');
  $routes->get('audit/input-manajemen-audit/delete/(:num)', 'InputManajemenAudit::delete/$1');

  $routes->get('audit/data-dukung', [DataDukung::class, 'index']);
  $routes->get('audit/input-data-dukung', [InputDataDukung::class, 'index']);
  $routes->get('audit/temuan', [Temuan::class, 'index']);
  $routes->get('audit/input-temuan', [InputTemuan::class, 'index']);

  $routes->get('akreditasi', [Akreditasi::class, 'index']);
  $routes->match(['GET', 'POST'], 'akreditasi', [Akreditasi::class, 'index']);
  $routes->get('akreditasi/download/(:segment)', [Akreditasi::class, 'download']);
  $routes->get('akreditasi/dashboard-periode', [DashboardPeriode::class, 'index']);
  $routes->match(['GET', 'POST'], 'akreditasi/dokumen-penetapan', [DokumenPenetapan::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/dokumen-penetapan/input', [DokumenPenetapan::class, 'input']);
  $routes->get('dokumen-penetapan/download/(:segment)', 'DokumenPenetapan::download/$1');
  $routes->match(['GET', 'POST'], 'akreditasi/kriteria', [KriteriaAkreditasi::class, 'index']);
  $routes->get('akreditasi/syarat-unggul', [SyaratUnggul::class, 'index']);
  $routes->match(['GET', 'POST'], 'akreditasi/syarat-unggul', [SyaratUnggul::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/instrumen-pemutu', [InstrumenPemutu::class, 'index']);
  $routes->match(['get', 'post'], 'akreditasi/instrumen-pemutu/input', [InstrumenPemutu::class, 'input']);
  $routes->match(['GET', 'POST'], 'akreditasi/periode', [Periode::class, 'index']);
  $routes->match(['GET', 'POST'], 'akreditasi/unit', [Unit::class, 'index']);
  $routes->match(['GET', 'POST'], 'akreditasi/lembaga', [Lembaga::class, 'index']);
  $routes->match(['GET', 'POST'], 'akreditasi/lembaga/input', [Lembaga::class, 'input']);
  $routes->match(['GET', 'POST'], 'akreditasi/input-data-pemutu', [InputDataPemutu::class, 'index']);
  $routes->match(['GET', 'POST'], 'akreditasi/isian-pemutu', [IsianPemutu::class, 'index']);

  $routes->match(['GET', 'POST'], 'akreditasi/input-data-pemutu', [InputDataPemutu::class, 'index']);
  $routes->post('akreditasi/input-data-pemutu/save', [InputDataPemutu::class, 'save']);
  $routes->get('akreditasi/input-data-pemutu/edit/(:num)', [InputDataPemutu::class, 'edit/$1']);
  $routes->post('akreditasi/input-data-pemutu/update/(:num)', [InputDataPemutu::class, 'update/$1']);
  $routes->get('akreditasi/input-data-pemutu/delete/(:num)', [InputDataPemutu::class, 'delete/$1']);
});

$routes->setAutoRoute(true);
?>