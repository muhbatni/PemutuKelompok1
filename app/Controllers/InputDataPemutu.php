<?php

namespace App\Controllers;

use App\Models\LembagaAkreditasiModel;
use App\Models\PeriodeModel;
use App\Models\UnitPemutuModel;

class InputDataPemutu extends BaseController
{
  protected $lembagaModel;
  protected $periodeModel;
  protected $unitpemutumodel;

  public function __construct()
  {
    $this->lembagaModel = new LembagaAkreditasiModel();
    $this->periodeModel = new PeriodeModel();
    $this->unitpemutumodel = new UnitPemutuModel();
  }


  public function index()
  {
    session()->remove('editData');

    $data = [
      'title' => 'Input Data Pemutu',
      'units' => $this->unitpemutumodel->getUnitsFromAkreditasi(),
      'periodes' => $this->periodeModel->getPeriodes(),
      'validation' => \Config\Services::validation(),
      'data_pemutu' => $this->unitpemutumodel->getPemutuData(),
      'editData' => null
    ];

    return view('layouts/header', $data)
      . view('akreditasi/input_data_pemutu/tables.php', $data)
      . view('layouts/footer');
  }

  public function getLembaga($id_unit)
  {
    $lembaga = $this->unitpemutumodel->getLembagaByUnit($id_unit);

    if (!$lembaga) {
      return $this->response->setJSON([
        'error' => 'Data lembaga tidak ditemukan untuk unit ini'
      ]);
    }

    return $this->response->setJSON([
      'id' => $lembaga['id_lembaga'],
      'nama' => $lembaga['nama']
    ]);
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
    $editData = $this->unitpemutumodel->find($id);

    if (!$editData) {
      return redirect()->to('/akreditasi/input-data-pemutu')->with('pesan', '<div class="alert alert-danger">Data tidak ditemukan.</div>');
    }

    $data = [
      'title' => 'Edit Data Pemutu',
      'units' => $this->unitpemutumodel->getUnitsFromAkreditasi(),
      'periodes' => $this->periodeModel->getPeriodes(),
      'validation' => \Config\Services::validation(),
      'data_pemutu' => $this->unitpemutumodel->getPemutuData(),
      'editData' => $editData
    ];

    return view('layouts/header', $data)
      . view('akreditasi/input_data_pemutu/form', $data)
      . view('layouts/footer');
  }


  public function update($id)
  {
    // Validate input
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

    // Prepare data for update
    $data = [
      'id_unit' => $this->request->getPost('id_unit'),
      'id_periode' => $this->request->getPost('id_periode'),
      'id_lembaga' => $this->request->getPost('id_lembaga'),
      'status' => $this->request->getPost('status'),
      'updated_at' => date('Y-m-d H:i:s')
    ];

    // Attempt to update
    if ($this->unitpemutumodel->update($id, $data)) {
      return redirect()->to('/akreditasi/input-data-pemutu')->with('pesan', '<div class="alert alert-success">✅ Data berhasil diperbarui.</div>');
    } else {
      return redirect()->back()->with('pesan', '<div class="alert alert-danger">❌ Gagal memperbarui data.</div>');
    }
  }

  public function input()
  {
    $data = [
      'title' => 'Form Input Data Pemutu',
      'units' => $this->unitpemutumodel->getUnitsFromAkreditasi(),
      'periodes' => $this->periodeModel->getPeriodes(),
      'validation' => \Config\Services::validation(),
      'editData' => null
    ];

    return view('layouts/header', $data)
      . view('akreditasi/input_data_pemutu/form', $data)
      . view('layouts/footer');
  }

  public function delete($id)
  {
    $this->unitpemutumodel->delete($id);
    return redirect()->to('/akreditasi/input-data-pemutu')->with('pesan', '<div class="alert alert-success">✅ Data berhasil dihapus.</div>');
  }
}
