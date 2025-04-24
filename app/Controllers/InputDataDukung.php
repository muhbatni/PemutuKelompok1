<?php
namespace App\Controllers;

class InputDataDukung extends BaseController
{
  public function index()
  {

    // // $periodeModel = new \App\Models\PeriodeModel();
    // // $data['periodes'] = $periodeModel->getPeriodes();

    // // $standarModel = new \App\Models\StandarModel();
    // // $data['standars'] = $standarModel->getStandars();

    // if ($this->request->getMethod() == 'POST'){
    //   $data = [
    //     'id_pelaksanaan' => $this ->request->getPost('id_pelaksanaan'),
    //     'id_pernyataan' => $this ->request->getPost('id_pernyataan'),
    //     'deskripsi' => $this ->request->getPost('deskripsi'),
    //     'dokumen' => $this ->request->getFile('dokumen')
    //   ];

    //   $model = new \App\Models\DataDukung();
    //   $saveResult = $model->insert($data);

    //   if($saveResult){
    //     session()->setFlashdata('Success', 'Data berhasil disimpan');
    //   } else{
    //     session()->setFlashdata('Error', 'Terjadi kesalahan saat menyimpan data.');
    //   }
    //   return redirect()->to(base_url('public/audit/pelaksanaan'));
    // }
//coba coba lah
    $data["title"] = "Tambah Data Dukung";
    echo view('layouts/header.php', $data);
    echo view('audit/data_dukung/form.php', $data);
    echo view('layouts/footer.php');
  }

}
?>