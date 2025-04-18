<?php
namespace App\Controllers;

class Lembaga extends BaseController
{
public function index()
    {
    $data["title"] = "Lembaga";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/Lembaga/form.php');
    echo view('layouts/footer.php');
    }

}
?>