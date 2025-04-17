<?php
namespace App\Controllers;

use App\Models\DokumenPenetapanModel;

class DokumenPenetapan extends BaseController
{
    public function index()
    {
        // Jika form disubmit (metode POST)
        if ($this->request->getMethod() == 'POST') {
            // Ambil data dari form
            $nomor = $this->request->getPost('nomor');
            $tanggal = $this->request->getPost('tanggal');
            $nama = $this->request->getPost('nama');
            $deskripsi = $this->request->getPost('deskripsi');
            $dokumen = $this->request->getFile('dokumen');

            // Simpan file dokumen
            $fileDokumen = $dokumen->getName();
            $dokumen->move(WRITEPATH . 'uploads/dokumen/', $fileDokumen);

            // Simpan data ke database
            $model = new DokumenPenetapanModel();
            $data = [
                'nomor' => $nomor,
                'tanggal' => $tanggal,
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'dokumen' => $fileDokumen,
            ];
            $model->save($data);

            // Set flashdata untuk pemberitahuan sukses
            session()->setFlashdata('success', 'Dokumen berhasil disimpan!');
            return redirect()->to(base_url('public/dokumen-penetapan')); // Kembali ke halaman yang sama
        }

        // Jika metode GET, tampilkan form
        $data["title"] = "Dokumen Penetapan";
        echo view('layouts/header.php', $data);
        echo view('dokumen-penetapan/form.php');
        echo view('layouts/footer.php');
    }
}

