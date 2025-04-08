<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data["title"] = "Judul";
        echo view('layouts/header.php', $data);
        echo view('layouts/tables.php');
        echo view('layouts/footer.php');
    }

}
