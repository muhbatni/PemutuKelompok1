<?php

namespace App\Controllers;

class RegistrasiSiswa extends BaseController
{
    public function getIndex()
    {
        return 'Hello World!';
    }

    public function getTampil()
    {
        return view('registrasi/tabel');
    }

    public function getFormulir()
    {
        return view('registrasi/form');
    }
}