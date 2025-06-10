<?php
namespace App\Controllers;

use App\Models\InstrumenPemutuModel;
use App\Models\KriteriaAkreditasiModel;
use App\Models\LembagaAkreditasiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class InstrumenPemutu extends BaseController
{
    protected $instrumenModel;
    protected $lembagaModel;

    public function __construct()
    {
        $this->instrumenModel = new InstrumenPemutuModel();
        $this->lembagaModel   = new LembagaAkreditasiModel();
        $this->kriteriaModel   = new KriteriaAkreditasiModel();
    }

    public function index()
    {
        $model = $this->instrumenModel;

        // Handle delete
        if ($this->request->getGet('delete')) {
            $id = $this->request->getGet('delete');
            $model->delete_by_id($id); // Call the delete_by_id method
            session()->setFlashdata('success', 'Data instrumen berhasil dihapus!');
            return redirect()->to(site_url('akreditasi/instrumen-pemutu'));
        }

        // Handle edit
        $editData = null;
        if ($this->request->getGet('edit')) {
            $id = $this->request->getGet('edit');
            $editData = $model->find($id);
        }

        // Handle save (create/update)
        if ($this->request->getMethod() === 'POST') {
            $id = $this->request->getPost('id');
            $data = [
                'id_lembaga' => $this->request->getPost('id_lembaga'),
                'jenjang'    => $this->request->getPost('jenjang'),
                'indikator'  => $this->request->getPost('indikator'),
                'kondisi'    => $this->request->getPost('kondisi'),
                'batas'      => $this->request->getPost('batas'),
            ];

            // Validasi batas
            // if (!is_numeric($data['batas'])) {
            //     return redirect()->back()->withInput()->with('error', 'Batas harus berupa angka.');
            // }

            if ($id) {
                $data['id'] = $id;
                $model->save($data);
                session()->setFlashdata('success', 'Instrumen berhasil diperbarui!');
            } else {
                $model->save($data);
                session()->setFlashdata('success', 'Instrumen berhasil disimpan!');
            }

            return redirect()->to(site_url('akreditasi/instrumen-pemutu'));
        }

        // Ambil data instrumen
        $dataInstrumen = $model->getInstrumenWithLembaga();
        foreach ($dataInstrumen as &$item) {
            $item['jenjang_text'] = $model->getJenjangText($item['jenjang']);
        }

        $data = [
            'title' => 'Instrumen Pemutu',
            'instrumen_pemutu' => $dataInstrumen,
            'edit' => $editData,
            'lembagas' => $this->lembagaModel->getLembagas(),
            'isEdit' => $editData !== null,
        ];

        return view('layouts/header', $data)
            . view('akreditasi/instrumen_pemutu/tables', $data)
            . view('layouts/footer');
    }

    public function input()
    {
        $model = $this->instrumenModel;
        $id = $this->request->getGet('id');
        $edit = null;

        if ($id) {
            $edit = $model->find($id);
            if (!$edit) {
                throw new PageNotFoundException('Data tidak ditemukan');
            }
        }

        // Form submit
        if ($this->request->getMethod() === 'POST') {

            $data = [
                'id_lembaga' => $this->request->getPost('id_lembaga'),
                'jenjang'    => $this->request->getPost('jenjang'),
                'indikator'  => $this->request->getPost('indikator'),
                'kondisi'    => $this->request->getPost('kondisi'),
                'batas'      => $this->request->getPost('batas'),
            ];

            if ($id) {
                $data['id'] = $id;
                $model->save($data);
                session()->setFlashdata('success', 'Data berhasil diperbarui.');
            } else {
                $model->save($data);
                session()->setFlashdata('success', 'Data berhasil disimpan.');
            }

            return redirect()->to(base_url('akreditasi/instrumen-pemutu'));
        }

        // Tampilkan form
        $data = [
            'title'    => $id ? 'Edit Instrumen Pemutu' : 'Tambah Instrumen Pemutu',
            'isEdit'   => $id ? true : false,
            'edit'     => $edit,
            'lembagas' => $this->lembagaModel->getLembagas(),
        ];

        return view('layouts/header', $data)
            . view('akreditasi/instrumen_pemutu/form', $data)
            . view('layouts/footer');
    }
}
