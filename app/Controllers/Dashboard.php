<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
  public function index()
  {
    $uri = service('uri');
    if ($uri->getSegment(1) === 'dashboard') {
      return redirectTo('');
    }
    $data["title"] = "Dashboard";
    echo view('layouts/header.php', $data);
    echo view('layouts/tables.php');
    echo view('layouts/footer.php');
  }

}
?>