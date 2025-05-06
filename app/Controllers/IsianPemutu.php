<?php

namespace App\Controllers;

use App\Models\IsianPemutuModel;
use App\Models\UnitPemutuModel;
use App\Models\InstrumenPemutuModel;

class IsianPemutu extends BaseController
{
  public function index()
  {
    $model = new IsianPemutuModel();
    $unitPemutuModel = new UnitPemutuModel();
    $instrumenPemutuModel = new InstrumenPemutuModel();

    // Hapus data
    if ($this->request->getGet('delete')) {
      $id = $this->request->getGet('delete');
      $model->delete($id);
      session()->setFlashdata('success', 'Data berhasil dihapus!');
      return redirect()->to(base_url('public/akreditasi/isian-pemutu'));
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

      return redirect()->to(base_url('public/akreditasi/isian-pemutu'));
    }

    //ambil data instrumenpemutu
    $data['instrumen_list'] = $instrumenPemutuModel->findAll(); // Ambil semua kolom
    
    // Dropdown Unit Pemutu(nama unit)
    $data['unitpemutus'] = $unitPemutuModel->select('p_unit_pemutu.id, m_unit.nama')
      ->join('m_unit', 'p_unit_pemutu.id_unit = m_unit.id')
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
    echo view('akreditasi/isian_pemutu/form.php');
    echo view('layouts/footer.php');
  }
}
