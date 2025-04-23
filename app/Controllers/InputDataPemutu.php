<?php

namespace App\Controllers;

use App\Models\UnitModel;
use App\Models\LembagaAkreditasiModel;
use App\Models\PeriodeModel;
use App\Models\UnitPemutuModel;

class InputDataPemutu extends BaseController
{
  protected $unitModel;
  protected $lembagaModel;
  protected $periodeModel;
  protected $unitpemutumodel;

  public function __construct()
  {
    $this->unitModel = new UnitModel();
    $this->lembagaModel = new LembagaAkreditasiModel();
    $this->periodeModel = new PeriodeModel();
    $this->unitpemutumodel = new UnitPemutuModel();
  }

  // Menampilkan form input
  public function index()
  {
    $data = [
      'title' => 'Input Data Pemutu',
      'units' => $this->unitModel->getUnits(),
      'lembagas' => $this->lembagaModel->getLembagas(),
      'periodes' => $this->periodeModel->getPeriodes(),
      'validation' => \Config\Services::validation(), // Untuk validasi
      'data_pemutu' => $this->unitpemutumodel->getPemutuData(), // Ambil data pemutu dari model
    ];

    return view('layouts/header', $data)
      . view('akreditasi/input_data_pemutu/form', $data)
      . view('layouts/footer');
  }

  // Menyimpan data ke database
  public function save()
  {
    // Validasi input
    if (
      !$this->validate([
        'id_unit' => 'required',
        'id_periode' => 'required',
        'id_lembaga' => 'required',
        'status' => 'required'
      ])
    ) {
      // Jika validasi gagal, kembali ke form dengan input sebelumnya
      return redirect()->back()->withInput()->with('validation', \Config\Services::validation());
    }

    // Menyimpan data ke database
    $data = [
      'id_unit' => $this->request->getPost('id_unit'),
      'id_periode' => $this->request->getPost('id_periode'),
      'id_lembaga' => $this->request->getPost('id_lembaga'),
      'status' => $this->request->getPost('status'),
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s')
    ];

    // Panggil metode simpan di model Anda
    $this->unitModel->insert($data); // Misalkan Anda menggunakan UnitModel untuk menyimpan data

    // Redirect setelah berhasil menyimpan data
    return redirect()->to('/input-data-pemutu')->with('success', 'Data berhasil disimpan.');
  }
}