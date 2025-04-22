<?php
namespace App\Controllers;

use App\Models\PeriodeModel;

class Periode extends BaseController
{
    public function index()
    {
        $model = new PeriodeModel();

        // Simpan data (create) jika form disubmit
        if ($this->request->getMethod() == 'POST') {
            // Ambil data dari form
            $tahun = $this->request->getPost('tahun');
            $ts = $this->request->getPost('ts');
            
            // Validasi input
            if (empty($tahun) || empty($ts)) {
                session()->setFlashdata('error', 'Tahun dan Tahun Ajaran harus diisi.');
            } else {
                // Siapkan data untuk dimasukkan
                $data = [
                    'tahun' => (int)$tahun,  // Pastikan tahun adalah integer
                    'ts'    => $ts,          // Pastikan ts adalah string
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
        $data['title'] = 'Manajemen Periode';
        $data['list'] = $model->findAll();

        // Tampilkan form dan data di view yang sama
        echo view('layouts/header', $data);
        echo view('akreditasi/periode/form', $data);
        echo view('layouts/footer');
    }
}