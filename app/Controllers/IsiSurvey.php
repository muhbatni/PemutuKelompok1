<?php
namespace App\Controllers;
class IsiSurvey extends BaseController
{
  public function index()
  {
    echo view('layouts/header.php', ["title" => "Isi Survey"]);
    echo view('survey_kepuasan/isi_survey/index.php');
    echo view('layouts/footer.php');
  }
}
?>