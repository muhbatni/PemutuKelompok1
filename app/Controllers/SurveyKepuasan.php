<?php
namespace App\Controllers;

class SurveyKepuasan extends BaseController
{
  public function index()
  {
    $data["title"] = "Survey Kepuasan";
    echo view('layouts/header.php', $data);
    echo view('survey_kepuasan/index.php');
    echo view('layouts/footer.php');
  }

}
?>