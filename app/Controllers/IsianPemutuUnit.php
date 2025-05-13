<?php

namespace App\Controllers;

use App\Models\IsianPemutuUnitModel;
use App\Models\UnitPemutuModel;
use App\Models\InstrumenPemutuModel;

class IsianPemutuUnit extends BaseController
{
  public function input()
  {
    $model = new IsianPemutuUnitModel();
    $unitPemutuModel = new UnitPemutuModel();
    $instrumenPemutuModel = new InstrumenPemutuModel();

    // Cek apakah form disubmit
    if ($this->request->getMethod() === 'POST') {
      $id = $this->request->getPost('id');
      $data = [
        'id_unitpemutu' => $this->request->getPost('id_unitpemutu'),
        'id_instrumen' => $this->request->getPost('id_instrumen'),
        'isian' => $this->request->getPost('isian'),
        'status' => $this->request->getPost('status'),
      ];

      if ($id) {
        $model->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diperbarui!');
      } else {
        $model->save($data);
        session()->setFlashdata('success', 'Data berhasil disimpan!');
      }

      return redirect()->to(base_url('public/akreditasi/isian-pemutu-unit'));
    }

    // Cek apakah ada parameter edit
    $editData = null;
    if ($this->request->getGet('id')) {
      $id = $this->request->getGet('id');
      $editData = $model->select('p_isian_pemutu.*, p_instrumen_pemutu.jenjang')
        ->join('p_instrumen_pemutu', 'p_instrumen_pemutu.id = p_isian_pemutu.id_instrumen')
        ->where('p_isian_pemutu.id', $id)
        ->first();
    }

    // Dropdown data
    $data['instrumen_list'] = $instrumenPemutuModel->getWithLembaga();

    $data['unitpemutus'] = $unitPemutuModel
      ->select('p_unit_pemutu.id, m_unit.nama as nama_unit, m_periode.ts as tahun_ajaran')
      ->join('m_unit', 'p_unit_pemutu.id_unit = m_unit.id')
      ->join('m_periode', 'p_unit_pemutu.id_periode = m_periode.id')
      ->findAll();

    $data['jenjang'] = $instrumenPemutuModel->select('id, jenjang')->findAll();

    $data['title'] = $editData ? "Edit Isian Pemutu" : "Input Isian Pemutu";
    $data['edit'] = $editData;

    echo view('layouts/header.php', $data);
    echo view('akreditasi/isian_pemutu_unit/form.php');
    echo view('layouts/footer.php');
  }

  public function index()
  {

    $isianPemutuModel = new IsianPemutuUnitModel();
    $data = [
    'isianPemutu' => $isianPemutuModel->getJoin(),
    'periodeList' => $isianPemutuModel->getAllPeriode(),
];


    $model = new IsianPemutuUnitModel();
    $unitPemutuModel = new UnitPemutuModel();
    $instrumenPemutuModel = new InstrumenPemutuModel();

    // Hapus data
    if ($this->request->getGet('delete')) {
      $id = $this->request->getGet('delete');
      $model->delete($id);
      session()->setFlashdata('success', 'Data berhasil dihapus!');
      return redirect()->to(base_url('public/akreditasi/isian-pemutu-unit'));
    }

    // Edit data
    $editData = null;
    if ($this->request->getGet('edit')) {
      $id = $this->request->getGet('edit');
      $editData = $model->find($id);
    }

    // Simpan data (create/update)
    if ($this->request->getMethod() === 'POST') {
      $id = $this->request->getPost('id');
      $data = [
        'id_unitpemutu' => $this->request->getPost('id_unitpemutu'),
        'id_instrumen' => $this->request->getPost('id_instrumen'),
        'isian' => $this->request->getPost('isian'),
        'status' => $this->request->getPost('status'),
      ];

      if ($id) {
        $model->update($id, $data);
        session()->setFlashdata('success', 'Data berhasil diperbarui!');
      } else {
        $model->save($data);
        session()->setFlashdata('success', 'Data berhasil disimpan!');
      }

      return redirect()->to(base_url('public/akreditasi/isian-pemutu-unit'));
    }

    //ambil data instrumenpemutu
    $data['instrumen_list'] = $instrumenPemutuModel->getWithLembaga();

    // Dropdown Unit Pemutu(nama unit)
    $data['unitpemutus'] = $unitPemutuModel
      ->select('p_unit_pemutu.id, m_unit.nama as nama_unit, m_periode.ts as tahun_ajaran')
      ->join('m_unit', 'p_unit_pemutu.id_unit = m_unit.id')
      ->join('m_periode', 'p_unit_pemutu.id_periode = m_periode.id')
      ->findAll();

    //Dropdown Instrumen Pemutu(jenjang)
    $data['jenjang'] = $instrumenPemutuModel->select('id, jenjang')->findAll();
    $data['instrumenPemutuModel'] = $instrumenPemutuModel;

    // Dropdown Jenjang
    $data['jenjang'] = $instrumenPemutuModel->select('id, jenjang')->findAll();

    // Data Tabel
    $isianRaw = $model->getJoin();
    $data['isian_pemutu'] = array_map(function ($item) use ($instrumenPemutuModel) {
      $item['jenjang_text'] = $instrumenPemutuModel->getJenjangText($item['jenjang']);
      return $item;
    }, $isianRaw);

    $data['edit'] = $editData;
    $data['title'] = "Isian Pemutu";

    echo view('layouts/header.php', $data);
    echo view('akreditasi/isian_pemutu_unit/tables.php');
    echo view('layouts/footer.php');
  }
}
