<?php

namespace App\Controllers;

use App\Models\IsianPemutuModel;
use App\Models\UnitPemutuModel;
use App\Models\InstrumenPemutuModel;

class IsianPemutu extends BaseController
{
  public function input()
  {
    $model = new IsianPemutuModel();
    $unitPemutuModel = new UnitPemutuModel();
    $instrumenPemutuModel = new InstrumenPemutuModel();

    // === AJAX Request: Get Instrumen berdasarkan Unit Pemutu ===
    if ($this->request->isAJAX() && $this->request->getGet('action') === 'get-instrumen') {
      $unitPemutuId = $this->request->getGet('id_unitpemutu');

      $unit = $unitPemutuModel
        ->select('p_unit_pemutu.id, m_unit.id_lembaga')
        ->join('m_unit', 'p_unit_pemutu.id_unit = m_unit.id')
        ->where('p_unit_pemutu.id', $unitPemutuId)
        ->first();

      if (!$unit || !$unit['id_lembaga']) {
        return $this->response->setJSON([]);
      }

      $instrumenList = $instrumenPemutuModel
        ->where('id_lembaga', $unit['id_lembaga'])
        ->findAll();

      return $this->response->setJSON($instrumenList);
    }

    // === POST Request: Simpan / Update data ===
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

      return redirect()->to(site_url('akreditasi/isian-pemutu'));
    }

    // === Mode Edit: Ambil data berdasarkan ID ===
    $editData = null;
    if ($this->request->getGet('id')) {
      $id = $this->request->getGet('id');
      $editData = $model
        ->select('p_isian_pemutu.*, p_instrumen_pemutu.jenjang')
        ->join('p_instrumen_pemutu', 'p_instrumen_pemutu.id = p_isian_pemutu.id_instrumen')
        ->where('p_isian_pemutu.id', $id)
        ->first();
    }

    // === Dropdown Unit Pemutu ===
    $data['unitpemutus'] = $unitPemutuModel
      ->select('p_unit_pemutu.id, m_unit.nama as nama_unit, m_periode.ts as tahun_ajaran')
      ->join('m_unit', 'p_unit_pemutu.id_unit = m_unit.id')
      ->join('m_periode', 'p_unit_pemutu.id_periode = m_periode.id')
      ->findAll();

    // === Dropdown Instrumen (semua dengan info lembaga & jenjang) ===
    $data['instrumen_list'] = $instrumenPemutuModel->getWithLembaga();

    // === Jenjang untuk select2 JS (jika diperlukan di tempat lain) ===
    $data['jenjang'] = $instrumenPemutuModel->select('id, jenjang')->findAll();

    $data['title'] = $editData ? "Edit Isian Pemutu" : "Input Isian Pemutu";
    $data['edit'] = $editData;

    echo view('layouts/header.php', $data);
    echo view('akreditasi/isian_pemutu/form.php');
    echo view('layouts/footer.php');
  }

  public function index()
  {

    $isianPemutuModel = new IsianPemutuModel();
    $data['isian_pemutu'] = $isianPemutuModel->getJoin();
    $data['periodeList'] = $isianPemutuModel->getAllPeriode();

    $model = new IsianPemutuModel();
    $unitPemutuModel = new UnitPemutuModel();
    $instrumenPemutuModel = new InstrumenPemutuModel();

    // Hapus data
    if ($this->request->getGet('delete')) {
      $id = $this->request->getGet('delete');
      $model->delete($id);
      session()->setFlashdata('success', 'Data berhasil dihapus!');
      return redirect()->to(site_url('akreditasi/isian-pemutu'));
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

      return redirect()->to(site_url('akreditasi/isian-pemutu'));
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
    echo view('akreditasi/isian_pemutu/tables.php');
    echo view('layouts/footer.php');
  }
}
