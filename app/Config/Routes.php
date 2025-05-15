<?php

use App\Controllers\Akreditasi;
use App\Controllers\InputManajemenAudit;
use App\Controllers\IsianPemutuUnit;
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
  $routes->get('isi-survey', [IsiSurvey::class, 'index']);
  $routes->match(['GET', 'POST'], 'isi-survey/(:segment)-(:num)', [IsiSurvey::class, 'isiSurvey/$1-$2']);
});

$routes->group('audit', ['filter' => 'auth'], function ($routes) {
  $routes->get('auditor', [Auditor::class, 'index']);
  $routes->match(['get', 'post'], 'auditor/input-auditor', [InputAuditor::class, 'index']);
  $routes->match(['get', 'post'], 'auditor/input-auditor/edit/(:segment)', [InputAuditor::class, 'edit/$1']);
  $routes->post('auditor/input-auditor/delete/(:segment)', [InputAuditor::class, 'delete/$1']);
  $routes->get('auditor/download/(:segment)', [InputAuditor::class, 'download/$1']);
  $routes->get('standar', [StandarAudit::class, 'index']);
  $routes->match(['get', 'post'], 'standar', 'StandarAudit::insert');
  $routes->get('standar/edit/(:num)', 'StandarAudit::edit/$1');
  $routes->get('standar/edit/(:num)/(:num)?', 'StandarAudit::edit/$1/$2');
  $routes->post('standar', 'StandarAudit::update');
  $routes->post('standar/update/(:num)', 'StandarAudit::update/$1');
  $routes->get('standar/delete/(:num)', 'StandarAudit::delete/$1');
  $routes->get('input-standar', [InputStandarAudit::class, 'index']);
  $routes->match(['get', 'post'], 'input-standar', [InputStandarAudit::class, 'index']);
  $routes->get('input-standar/edit/(:num)', [InputStandarAudit::class, 'edit/$1']);
  $routes->post('input-standar/update/(:num)', [InputStandarAudit::class, 'update/$1']);
  $routes->get('standar/download/(:segment)', [InputStandarAudit::class, 'download/$1']);
  $routes->get('manajemen-audit', [ManajemenAudit::class, 'index']);
  $routes->match(['GET', 'POST'], 'input-manajemen-audit', [InputManajemenAudit::class, 'index']);
  $routes->get('input-manajemen-audit/edit/(:num)', 'InputManajemenAudit::edit/$1');
  $routes->post('input-manajemen-audit/update/(:num)', 'InputManajemenAudit::update/$1');
  $routes->get('input-manajemen-audit/delete/(:num)', 'InputManajemenAudit::delete/$1');
  $routes->get('pelaksanaan-audit', [PelaksanaanAudit::class, 'index']);
  $routes->get('pelaksanaan-audit/edit/(:num)', 'PelaksanaanAudit::edit/$1');
  $routes->get('pelaksanaan-audit/getPernyataanByStandar/(:num)', 'PelaksanaanAudit::getPernyataanByStandar/$1');
  $routes->get('pelaksanaan-audit/getDetailPernyataan/(:num)', 'PelaksanaanAudit::getDetailPernyataan/$1');
  $routes->post('pelaksanaan-audit/simpan', 'PelaksanaanAudit::simpan');
  $routes->get('data-dukung', [DataDukung::class, 'index']);
  $routes->match(['get', 'post'], 'input-data-dukung', [InputDataDukung::class, 'index']);
  $routes->get('input-data-dukung/edit/(:num)', [InputDataDukung::class, 'edit/$1']);
  $routes->post('input-data-dukung/update/(:num)', [InputDataDukung::class, 'update/$1']);
  $routes->get('data-dukung/delete/(:num)', [InputDataDukung::class, 'delete/$1']);
  $routes->get('get-pelaksanaan-info/(:num)', [InputDataDukung::class, 'getPelaksanaanInfo/$1']);
  $routes->get('get-pernyataan-info/(:num)', [InputDataDukung::class, 'getPernyataanInfo/$1']);
  $routes->get('get-pernyataan-by-standar/(:num)', 'InputDataDukung::getPernyataanByStandar/$1');
  $routes->get('data-dukung/download/(:segment)', 'InputDataDukung::download/$1');
  $routes->get('temuan', [Temuan::class, 'index']);
  $routes->match(['get','post'],'input-temuan', [InputTemuan::class, 'index']);
  $routes->get('input-temuan/edit/(:num)', [InputTemuan::class, 'edit/$1']);
  $routes->post('input-temuan/update/(:num)', [InputTemuan::class, 'update/$1']);
  $routes->get('input-temuan/delete/(:num)', [InputTemuan::class, 'delete/$1']);
});

$routes->group('akreditasi', ['filter' => 'auth'], function ($routes) {
  $routes->match(['GET', 'POST'], '/', [Akreditasi::class, 'index']);
  $routes->get('download/(:segment)', [Akreditasi::class, 'download']);
  $routes->get('dashboard-periode', [DashboardPeriode::class, 'index']);
  $routes->match(['GET', 'POST'], 'input', [Akreditasi::class, 'input']);
  $routes->match(['GET', 'POST'], 'dokumen-penetapan', [DokumenPenetapan::class, 'index']);
  $routes->match(['GET', 'POST'], 'dokumen-penetapan/input', [DokumenPenetapan::class, 'input']);
  $routes->get('dokumen-penetapan/download/(:segment)', [DokumenPenetapan::class, 'download/$1']);
  $routes->match(['GET', 'POST'], 'kriteria', [KriteriaAkreditasi::class, 'index']);
  $routes->match(['GET', 'POST'], 'kriteria/input', [KriteriaAkreditasi::class, 'input']);
  $routes->get('syarat-unggul', [SyaratUnggul::class, 'index']);
  $routes->match(['GET', 'POST'], 'syarat-unggul', [SyaratUnggul::class, 'index']);
  $routes->match(['GET', 'POST'], 'syarat-unggul/input', [SyaratUnggul::class, 'input']);
  $routes->match(['GET', 'POST'], 'instrumen-pemutu', [InstrumenPemutu::class, 'index']);
  $routes->match(['GET', 'POST'], 'instrumen-pemutu/input', [InstrumenPemutu::class, 'input']);
  $routes->match(['GET', 'POST'], 'periode', [Periode::class, 'index']);
  $routes->match(['GET', 'POST'], 'periode/input', [Periode::class, 'input']);
  $routes->match(['GET', 'POST'], 'unit', [Unit::class, 'index']);
  $routes->match(['GET', 'POST'], 'unit/input', [Unit::class, 'input']);
  $routes->match(['GET', 'POST'], 'lembaga', [Lembaga::class, 'index']);
  $routes->match(['GET', 'POST'], 'lembaga/input', [Lembaga::class, 'input']);
  $routes->match(['GET', 'POST'], 'input-data-pemutu', [InputDataPemutu::class, 'index']);
  $routes->match(['GET', 'POST'], 'input-data-pemutu/input', [InputDataPemutu::class, 'input']);
  $routes->match(['GET', 'POST'], 'isian-pemutu', [IsianPemutu::class, 'index']);
  $routes->match(['GET', 'POST'], 'isian-pemutu/input', [IsianPemutu::class, 'input']);
  $routes->match(['GET', 'POST'], 'isian-pemutu-unit', [IsianPemutuUnit::class, 'index']);
  $routes->match(['GET', 'POST'], 'isian-pemutu-unit/input', [IsianPemutuUnit::class, 'input']);
  $routes->match(['GET', 'POST'], 'input-data-pemutu', [InputDataPemutu::class, 'index']);
  $routes->post('input-data-pemutu/save', [InputDataPemutu::class, 'save']);
  $routes->get('input-data-pemutu/edit/(:num)', [InputDataPemutu::class, 'edit/$1']);
  $routes->post('input-data-pemutu/update/(:num)', [InputDataPemutu::class, 'update/$1']);
  $routes->get('input-data-pemutu/delete/(:num)', [InputDataPemutu::class, 'delete/$1']);
  $routes->get('input-data-pemutu/get-lembaga/(:num)', [InputDataPemutu::class, 'getLembaga/$1']);
});

$routes->setAutoRoute(true);
?>