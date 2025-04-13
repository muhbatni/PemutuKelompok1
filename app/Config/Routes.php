<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
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
