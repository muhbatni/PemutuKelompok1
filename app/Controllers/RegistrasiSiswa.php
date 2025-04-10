<?php

namespace App\Controllers;

class RegistrasiSiswa extends BaseController
{
  public function getIndex()
  {
    return 'Hello World!';
  }

  public function getFormulir()
  {
    return view('registrasi/form');
  }
}