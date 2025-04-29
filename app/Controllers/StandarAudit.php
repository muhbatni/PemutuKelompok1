<?php
namespace App\Controllers;

use App\Models\StandarModel;
use App\Models\PernyataanModel;
use App\Models\AuditStandarModel;

class StandarAudit extends BaseController
{

    protected $AuditStandarModel;  // Menambahkan properti untuk model
    protected $PernyataanModel;   // Pastikan model PernyataanModel juga ditambahkan

    public function __construct()
    {
        // Inisialisasi model
        $this->AuditStandarModel = new AuditStandarModel(); // Membuat instance model AuditStandar
        $this->PernyataanModel = new PernyataanModel();  // Membuat instance model PernyataanModel
    }

    public function index()
    {

        $model = new StandarModel();
        $data["title"] = "Standar Audit";
        $data["standar"] = $model->findAll(); // ambil data dari DB

        // hapus data 
        if ($this->request->getGet('delete')) {
            $id = $this->request->getGet('delete');
            $model->delete($id);
            session()->setFlashdata('success', 'Data input standar berhasil dihapus!');
            return redirect()->to(base_url('public/audit/standar'));
        }
        echo view('layouts/header.php', $data);
        echo view('audit/standar_audit/tables.php', $data);
        echo view('layouts/footer.php');

    }

    public function insert()
    {
        $model = new PernyataanModel();
        $pernyataanModel = new PernyataanModel(); // <-- Ini yang benar untuk ambil data

        // $data["data_standar"] = $pernyataanModel->findAll();
        $data['title'] = "Input Pernyataan Standar";

        // Ambil id_standar dari GET
        $data['id_standar'] = $this->request->getGet('id_standar');

        if ($this->request->getMethod() === 'POST') {
            $insertData = [
                'id_standar' => $this->request->getPost('id_standar'),
                'pernyataan' => $this->request->getPost('pernyataan'),
                'indikator' => $this->request->getPost('indikator'),
                'kondisi' => $this->request->getPost('kondisi'),
                'batas' => $this->request->getPost('batas')
            ];

            $model->insert($insertData);

            /// Simpan pesan sukses dan tetap pada halaman yang sama
            session()->setFlashdata('success', 'Pernyataan berhasil ditambahkan!');
            return redirect()->to(base_url('public/audit/standar/edit/' . $this->request->getPost('id_standar')))
                ->withInput(); // Pastikan input tetap ada
        }

        echo view('layouts/header.php', $data);
        echo view('audit/standar_audit/edit', $data);
        echo view('layouts/footer.php');
    }


    public function edit($id_standar, $id_pernyataan =null)
    {
        // Ambil data standar berdasarkan id_audit
        $standar = $this->AuditStandarModel->getStandarByAudit($id_standar);

        // Tambahan: Ambil daftar pernyataan yang terkait id_standar
        $pernyataanModel = new PernyataanModel();
        $data_standar = $pernyataanModel->where('id_standar', $id_standar)->findAll();
        $data['pernyataan'] = $pernyataanModel->find($id_pernyataan);
        $data = [
            'title' => 'Pernyataan Standar',
            'standar' => $standar,
            'data_standar' => $data_standar,
            'id_standar' => $id_standar,
            'pernyataan' => $data['pernyataan'],
        ];

        echo view('layouts/header', $data);
        echo view('audit/standar_audit/edit', $data); // Mengirim data ke view
        echo view('layouts/footer');
    }

    public function delete($id_pernyataan)
    {
        $model = new PernyataanModel(); // Ganti modelnya ke PernyataanModel

        $data = $model->find($id_pernyataan);

        if ($data) {
            $id_standar = $data['id_standar']; // Ambil id_standar untuk redirect nanti
            $model->delete($id_pernyataan);

            return redirect()->to(base_url('public/audit/standar/edit/' . $id_standar))
                ->with('success', 'Pernyataan berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    public function update()
    {
        $model = new PernyataanModel();

        $id_pernyataan = $this->request->getPost('id_pernyataan');

        $data = [
            'pernyataan' => $this->request->getPost('pernyataan'),
            'indikator' => $this->request->getPost('indikator'),
            'kondisi' => $this->request->getPost('kondisi'),
            'batas' => $this->request->getPost('batas'),
        ];

        if ($id_pernyataan) {
            $model->update($id_pernyataan, $data);

            session()->setFlashdata('success', 'Pernyataan berhasil diperbarui!');
            return redirect()->to(base_url('public/audit/standar/edit/' . $this->request->getPost('id_standar')));
        } else {
            return redirect()->back()->with('error', 'ID Pernyataan tidak ditemukan.');
        }
    }
}
?>