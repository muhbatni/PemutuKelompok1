<?php
namespace App\Controllers;

use App\Models\PeriodeModel;

class Periode extends BaseController
{

    public function input()
    {
        $model = new PeriodeModel();

        // Ambil ID jika ada
        $id = $this->request->getGet('id');
        $edit = null;

        // Kalau ada ID, ambil data lama untuk ditampilkan di form
        if ($id) {
            $edit = $model->find($id);
            if (!$edit) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
            }
        }

        // Jika disubmit (POST)
        if ($this->request->getMethod() === 'post') {
            $data = [
                'tahun' => $this->request->getPost('tahun'),
                'ts' => $this->request->getPost('ts'),
            ];

            // Update jika ID ada, insert jika tidak
            if ($id) {
                $model->update($id, $data);
                session()->setFlashdata('success', 'Data berhasil diperbarui.');
            }

            return redirect()->to(base_url('akreditasi/periode'));
        }

        // Tampilkan form
        $data = [
            'title' => $id ? 'Edit Periode' : 'Tambah Periode',
            'isEdit' => $id ? true : false,
            'edit' => $edit,
        ];

        echo view('layouts/header', $data);
        echo view('akreditasi/periode/form', $data);
        echo view('layouts/footer');
    }

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
        echo view('akreditasi/periode/tables.php');
        echo view('layouts/footer.php');
    }
}