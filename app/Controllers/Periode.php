<?php
namespace App\Controllers;

use App\Models\PeriodeModel;

class Periode extends BaseController
{
    public function index()
    {
        $model = new PeriodeModel();

        // Hapus data
        if ($this->request->getGet('delete')) {
            $id = $this->request->getGet('delete');
            $model->delete($id);
            session()->setFlashdata('success', 'Data periode berhasil dihapus!');
            return redirect()->to(base_url('public/akreditasi/periode'));
        }

        // Ambil data untuk edit
        $editData = null;
        if ($this->request->getGet('edit')) {
            $id = $this->request->getGet('edit');
            $editData = $model->find($id);
        }

        // Simpan (create / update)
        if ($this->request->getMethod() == 'POST') {
            $id = $this->request->getPost('id');
            $tahun = $this->request->getPost('tahun');
            $tahunAjaran = $this->request->getPost('ts');

            if (empty($tahun) || empty($tahunAjaran)) {
                session()->setFlashdata('error', 'Tahun dan Tahun Ajaran wajib diisi!');
            } else {
                $data = [
                    'tahun' => (int) $tahun,
                    'ts' => $tahunAjaran,
                ];

                if ($id) {
                    $model->update($id, $data);
                    session()->setFlashdata('success', 'Data periode berhasil diperbarui!');
                } else {
                    $model->save($data);
                    session()->setFlashdata('success', 'Data periode berhasil disimpan!');
                }

                return redirect()->to(base_url('public/akreditasi/periode'));
            }
        }

        // Ambil semua data
        $data['title'] = 'Manajemen Periode';
        $data['periode'] = $model->findAll();
        $data['edit'] = $editData;

        echo view('layouts/header.php', $data);
        echo view('akreditasi/periode/form.php');
        echo view('layouts/footer.php');
    }
}