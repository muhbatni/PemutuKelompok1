<?php
namespace App\Controllers;

use App\Models\KriteriaAkreditasiModel;
use App\Models\LembagaAkreditasiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class KriteriaAkreditasi extends BaseController
{
    protected $kriteriaModel;
    protected $lembagaModel;

    public function __construct()
    {
        $this->kriteriaModel = new KriteriaAkreditasiModel();
        $this->lembagaModel = new LembagaAkreditasiModel();
    }

    public function index()
    {
        // Handle delete
        if ($this->request->getGet('delete')) {
            $id = $this->request->getGet('delete');
            $this->kriteriaModel->delete($id);
            session()->setFlashdata('success', 'Data berhasil dihapus!');
            return redirect()->to(site_url('akreditasi/kriteria'));
        }

        // Ambil semua data
        $data = [
            'title' => 'Kriteria Akreditasi',
            'kriteria' => $this->kriteriaModel->getKriteriaWithLembaga(),
            'lembagas' => $this->lembagaModel->getLembagas(),
        ];

        return view('layouts/header', $data)
            . view('akreditasi/kriteria_akreditasi/tables', $data)
            . view('layouts/footer');
    }

    public function input()
    {
        $id = $this->request->getGet('id');
        $edit = null;

        if ($id) {
            $edit = $this->kriteriaModel->find($id);
            if (!$edit) {
                throw new PageNotFoundException('Data tidak ditemukan');
            }
        }

        // Handle form submit
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'id_lembaga' => $this->request->getPost('id_lembaga'),
                'kode' => $this->request->getPost('kode'),
                'nama' => $this->request->getPost('nama'),
            ];

            if ($id) {
                $data['id'] = $id;
                $this->kriteriaModel->save($data);
                session()->setFlashdata('success', 'Data berhasil diperbarui.');
            } else {
                $this->kriteriaModel->save($data);
                session()->setFlashdata('success', 'Data berhasil disimpan.');
            }

            return redirect()->to(site_url('akreditasi/kriteria'));
        }

        // Ambil id_lembaga dari query string untuk mode tambah
        $selectedLembaga = !$id ? $this->request->getGet('id_lembaga') : null;

        // Tampilkan form input/edit
        $data = [
            'title' => $id ? 'Edit Kriteria Akreditasi' : 'Tambah Kriteria Akreditasi',
            'isEdit' => $id ? true : false,
            'edit' => $edit,
            'lembagas' => $this->lembagaModel->getLembagas(),
            'selected_lembaga' => $selectedLembaga,
        ];

        return view('layouts/header', $data)
            . view('akreditasi/kriteria_akreditasi/form', $data)
            . view('layouts/footer');
    }
}
