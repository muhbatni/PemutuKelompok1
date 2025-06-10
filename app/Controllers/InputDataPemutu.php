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
      'lembagas' => $this->lembagaModel->getLembagas(),
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
    // Validasi input dengan pesan error yang jelas
    if (
      !$this->validate([
        'id_unit' => [
          'rules' => 'required',
          'errors' => ['required' => 'Unit harus dipilih']
        ],
        'id_periode' => [
          'rules' => 'required',
          'errors' => ['required' => 'Periode harus dipilih']
        ],
      ])
    ) {
      return redirect()->back()
        ->withInput()
        ->with('validation', $this->validator)
        ->with('pesan', '<div class="alert alert-danger">Mohon periksa kembali input Anda.</div>');
    }

    try {
      // Cek duplikasi data
      $existingData = $this->unitpemutumodel->where([
        'id_unit' => $this->request->getPost('id_unit'),
        'id_periode' => $this->request->getPost('id_periode')
      ])->first();

      if ($existingData) {
        return redirect()->back()
          ->withInput()
          ->with('pesan', '<div class="alert alert-danger">Data untuk unit dan periode ini sudah ada.</div>');
      }

       $data = [
            'id_unit' => $this->request->getPost('id_unit'),
            'id_periode' => $this->request->getPost('id_periode'),
            'id_lembaga' => $this->request->getPost('id_lembaga'),
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $inserted = $this->unitpemutumodel->insert($data);
        
        if ($inserted) {
            return redirect()->to('/akreditasi/input-data-pemutu')
                ->with('pesan', '<div class="alert alert-success">✅ Data berhasil disimpan.</div>');
        }
        
        throw new \Exception('Gagal menyimpan data');

    } catch (\Exception $e) {
        log_message('error', 'Error saving data: ' . $e->getMessage());
        return redirect()->back()
            ->withInput()
            ->with('pesan', '<div class="alert alert-danger">Terjadi kesalahan saat menyimpan data.</div>');
    }
  }

  public function edit($id)
  {
    $editData = $this->unitpemutumodel->find($id);

    if (!$editData) {
      return redirect()->to('/akreditasi/input-data-pemutu')
        ->with('pesan', '<div class="alert alert-danger">Data tidak ditemukan.</div>');
    }

    // Ambil data lembaga
    $lembaga = $this->unitpemutumodel->getLembagaByUnit($editData['id_unit']);
    if ($lembaga) {
      $editData['lembaga_nama'] = $lembaga['nama'];
    }

    // Ambil data status berbasis isian - ini yang perlu ditambahkan
    $statusData = $this->unitpemutumodel->getDetailPemutuData($id);
    if ($statusData) {
      $editData['status'] = $statusData['status'];
      $editData['status_class'] = $statusData['status_class'];
      $editData['status_value'] = $statusData['status_value'];
    }

    $data = [
      'title' => 'Edit Data Pemutu',
      'units' => $this->unitpemutumodel->getUnitsFromAkreditasi(),
      'periodes' => $this->periodeModel->getPeriodes(),
      'editData' => $editData
    ];

    return view('layouts/header', $data)
      . view('akreditasi/input_data_pemutu/form', $data)
      . view('layouts/footer');
  }

  public function update($id)
  {
    // Validasi input dengan pesan error yang jelas
    if (
      !$this->validate([
        'id_unit' => [
          'rules' => 'required',
          'errors' => ['required' => 'Unit harus dipilih']
        ],
        'id_periode' => [
          'rules' => 'required',
          'errors' => ['required' => 'Periode harus dipilih']
        ],
        'id_lembaga' => [
          'rules' => 'required',
          'errors' => ['required' => 'Lembaga harus dipilih']
        ],
        'status' => [
          'rules' => 'required',
          'errors' => ['required' => 'Status harus dipilih']
        ]
      ])
    ) {
      return redirect()->back()
        ->withInput()
        ->with('validation', $this->validator)
        ->with('pesan', '<div class="alert alert-danger">Mohon periksa kembali input Anda.</div>');
    }

    try {
      // Cek apakah data exists
      $existingData = $this->unitpemutumodel->find($id);
      if (!$existingData) {
        return redirect()->to('/akreditasi/input-data-pemutu')
          ->with('pesan', '<div class="alert alert-danger">Data tidak ditemukan.</div>');
      }

      // Cek duplikasi dengan data lain
      $duplicateCheck = $this->unitpemutumodel->where([
        'id_unit' => $this->request->getPost('id_unit'),
        'id_periode' => $this->request->getPost('id_periode')
      ])->where('id !=', $id)->first();

      if ($duplicateCheck) {
        return redirect()->back()
          ->withInput()
          ->with('pesan', '<div class="alert alert-danger">Data untuk unit dan periode ini sudah ada.</div>');
      }

      $data = [
        'id_unit' => $this->request->getPost('id_unit'),
        'id_periode' => $this->request->getPost('id_periode'),
        'id_lembaga' => $this->request->getPost('id_lembaga'),
        'status' => $this->request->getPost('status'),
        'updated_at' => date('Y-m-d H:i:s')
      ];

      if ($this->unitpemutumodel->update($id, $data)) {
        return redirect()->to('/akreditasi/input-data-pemutu')
          ->with('pesan', '<div class="alert alert-success">✅ Data berhasil diperbarui.</div>');
      } else {
        return redirect()->back()
          ->withInput()
          ->with('pesan', '<div class="alert alert-danger">Gagal memperbarui data.</div>');
      }

    } catch (\Exception $e) {
      log_message('error', 'Error updating data: ' . $e->getMessage());
      return redirect()->back()
        ->withInput()
        ->with('pesan', '<div class="alert alert-danger">Terjadi kesalahan saat memperbarui data.</div>');
    }
  }

  public function input()
  {
    $data = [
      'title' => 'Form Input Data Pemutu',
      'units' => $this->unitpemutumodel->getAllUnits(), // Ganti ini
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

  public function getStatus($id_unit, $id_periode)
  {
    $result = $this->unitpemutumodel->getStatusByUnitPeriode($id_unit, $id_periode);

    return $this->response->setJSON([
      'total_isian' => (int) $result['total_isian'],
      'jumlah_lolos' => (int) $result['jumlah_lolos']
    ]);
  }
}
