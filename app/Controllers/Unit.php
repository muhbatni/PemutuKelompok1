<?php
namespace App\Controllers;

use App\Models\UnitModel;

class Unit extends BaseController
{

public function index()
    {

        $model = new UnitModel();

        // Simpan data (create) jika form disubmit
        if ($this->request->getMethod() == 'POST') {
            // Ambil data dari form
            $nama = $this->request->getPost('nama');
            $parent = $this->request->getPost('parent');
            
            // Validasi input
            if (empty($nama) || empty($parent)) {
                session()->setFlashdata('error', 'Nama dan Parent harus diisi.');
            } else {
                // Siapkan data untuk dimasukkan
                $data = [
                    'nama' => $nama,
                    'parent' => $parent,
                ];

                // Insert data ke database
                if ($model->insert($data)) {
                    session()->setFlashdata('success', 'Data periode berhasil disimpan.');
                } else {
                    session()->setFlashdata('error', 'Gagal menyimpan data periode.');
                }
            }
        }

    // Ambil data periode yang ada untuk ditampilkan
    $data['title'] = 'Manajemen Unit';
    $data['list'] = $model->findAll();

    // Tampilkan form dan data di view yang sama
    $data["title"] = "Unit";
    echo view('layouts/header.php', $data);
    echo view('akreditasi/unit/form.php');
    echo view('layouts/footer.php');
    }

}
?>