<?php
namespace App\Controllers;
class ManajemenSurvey extends BaseController
{
  public function index()
  {
    echo view('layouts/header.php', ["title" => "Manajemen Survey"]);
    echo view('survey_kepuasan/manajemen_survey/index.php');
    echo view('layouts/footer.php');
  }
}
?>