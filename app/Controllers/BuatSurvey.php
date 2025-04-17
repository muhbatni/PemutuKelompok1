<?php
namespace App\Controllers;
class BuatSurvey extends BaseController
{
  public function index()
  {
    echo view('layouts/header.php', ["title" => "Buat Survey"]);
    echo view('survey_kepuasan/buat_survey/index.php');
    echo view('layouts/footer.php');
  }
}
?>