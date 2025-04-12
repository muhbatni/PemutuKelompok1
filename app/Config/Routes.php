<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get("/survey-kepuasan", "SurveyKepuasan::index");
$routes->get("/input-auditor","InputAuditor::index");
$routes->setAutoRoute(true);
?>

