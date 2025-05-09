<?php
namespace App\Controllers;

use App\Models\PelaksanaanAuditModel;
use App\Models\TemuanModel;

class InputTemuan extends BaseController
{

  protected $pelaksanaanAuditModel;

  public function __construct()
  {
    $this->pelaksanaanAuditModel = new PelaksanaanAuditModel();
  }

  public function index()
  {
    $unit_list = $this->pelaksanaanAuditModel->getUnitList();

    if ($this->request->getMethod() == 'POST') {
      $dataTemuan = [
        'id_unit' => $this->request->getPost('id_unit'),
        'kondisi' => $this->request->getPost('kondisi'),
        'rencana_perbaikan' => $this->request->getPost('rencana_perbaikan'),
        'tanggal_perbaikan' => $this->request->getPost('tanggal_perbaikan'),
        'catatan' => $this->request->getPost('catatan'),
        'status' => $this->request->getPost('status')
      ];

      if (empty($dataTemuan['id_unit']) || empty($dataTemuan['kondisi']) || empty($dataTemuan['rencana_perbaikan']) || empty($dataTemuan['tanggal_perbaikan'])) {
        session()->setFlashdata('Error', 'Semua field harus diisi');
        return redirect()->to('/audit/input-temuan'); // Ganti dengan URL yang sesuai
      }

      $model = new TemuanModel();
      $model->insert($dataTemuan);


      return redirect()->to('/audit/temuan');
    }

    $data = [
      'title' => 'Input Temuan',
      'unit_list' => $unit_list,
    ];

    echo view('layouts/header.php', $data);
    echo view('audit/temuan/form.php', $data);
    echo view('layouts/footer.php');
  }

  public function edit($id)
  {

    $unit_list = $this->pelaksanaanAuditModel->getUnitList();


    $model = new TemuanModel();
    $temuan = $model->find($id);

    $data = [
      'title' => 'Edit Temuan',
      'temuan' => $temuan,
      'unit_list' => $unit_list,
    ];

    echo view('layouts/header.php', $data);
    echo view('audit/temuan/form.php', $data);
    echo view('layouts/footer.php');
  }

  public function update($id)
  {
    $model = new TemuanModel();

    $data = [
      'id_unit' => $this->request->getPost('id_unit'),
      'kondisi' => $this->request->getPost('kondisi'),
      'rencana_perbaikan' => $this->request->getPost('rencana_perbaikan'),
      'tanggal_perbaikan' => $this->request->getPost('tanggal_perbaikan'),
      'catatan' => $this->request->getPost('catatan'),
      'status' => $this->request->getPost('status'),
    ];

    $model->update($id, $data);

    return redirect()->to(base_url('public/audit/temuan'))->with('Success', 'Data berhasil diupdate!');
  }

  public function delete($id)
  {
    $model = new TemuanModel();
    $model->delete($id);

    return redirect()->to(base_url('public/audit/temuan'))->with('Success', 'Data berhasil dihapus!');
  }


}
?>