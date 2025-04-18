<?php
namespace App\Controllers;

class Unit extends BaseController
{
public function index()
    {
    $data["title"] = "Unit";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/unit/form.php');
    echo view('layouts/footer.php');
    }

}
?>