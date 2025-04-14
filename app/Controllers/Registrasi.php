<?php

namespace App\Controllers;

use App\Models\UserModel; // Ensure you have a UserModel for database interaction

class Registrasi extends BaseController
{
  public function index()
  {
    echo view("registrasi/index.php");
  }
}