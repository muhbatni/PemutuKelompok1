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

  public function index()
  {
    $data = [
      'title' => 'Input Data Pemutu',
      'units' => $this->unitModel->getUnits(),
      'lembagas' => $this->lembagaModel->getLembagas(),
      'periodes' => $this->periodeModel->getPeriodes(),
      'validation' => \Config\Services::validation(),
      'data_pemutu' => $this->unitpemutumodel->getPemutuData(),
      'editData' => null
    ];

    return view('layouts/header', $data)
      . view('akreditasi/input_data_pemutu/form', $data)
      . view('layouts/footer');
  }

  public function save()
  {
    if (
      !$this->validate([
        'id_unit' => 'required',
        'id_periode' => 'required',
        'id_lembaga' => 'required',
        'status' => 'required'
      ])
    ) {
      return redirect()->back()->withInput()->with('validation', $this->validator);
    }

    $data = [
      'id_unit' => $this->request->getPost('id_unit'),
      'id_periode' => $this->request->getPost('id_periode'),
      'id_lembaga' => $this->request->getPost('id_lembaga'),
      'status' => $this->request->getPost('status'),
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s')
    ];

    $this->unitpemutumodel->insert($data);

    return redirect()->to('/akreditasi/input-data-pemutu')->with('pesan', '<div class="alert alert-success">✅ Data berhasil disimpan.</div>');
  }

  public function edit($id)
  {
    $data = [
      'title' => 'Edit Data Pemutu',
      'units' => $this->unitModel->getUnits(),
      'lembagas' => $this->lembagaModel->getLembagas(),
      'periodes' => $this->periodeModel->getPeriodes(),
      'validation' => \Config\Services::validation(),
      'data_pemutu' => $this->unitpemutumodel->getPemutuData(),
      'editData' => null // Set null karena kita menggunakan modal
    ];

    return view('layouts/header', $data)
      . view('akreditasi/input_data_pemutu/form', $data)
      . view('layouts/footer');
  }

  public function update($id)
  {
    if (
      !$this->validate([
        'id_unit' => 'required',
        'id_periode' => 'required',
        'id_lembaga' => 'required',
        'status' => 'required'
      ])
    ) {
      return redirect()->back()->withInput()->with('validation', $this->validator);
    }

    $data = [
      'id_unit' => $this->request->getPost('id_unit'),
      'id_periode' => $this->request->getPost('id_periode'),
      'id_lembaga' => $this->request->getPost('id_lembaga'),
      'status' => $this->request->getPost('status'),
      'updated_at' => date('Y-m-d H:i:s')
    ];

    $this->unitpemutumodel->update($id, $data);

    return redirect()->to('/akreditasi/input-data-pemutu')->with('pesan', '<div class="alert alert-success">✅ Data berhasil diperbarui.</div>');
  }

  public function delete($id)
  {
    $this->unitpemutumodel->delete($id);
    return redirect()->to('/akreditasi/input-data-pemutu')->with('pesan', '<div class="alert alert-success">✅ Data berhasil dihapus.</div>');
  }
}