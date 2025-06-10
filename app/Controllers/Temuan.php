<?php
namespace App\Controllers;

use App\Models\TemuanModel;

class Temuan extends BaseController
{
    public function index()
    {
        $model = new TemuanModel();
        $unitModel = new \App\Models\UnitModel();

        $temuan = $model->findAll();

        // Tambahkan nama unit ke setiap baris temuan
        foreach ($temuan as &$row) {
            $unit = $unitModel->getUnitById($row['id_unit']);
            $row['nama_unit'] = $unit ? $unit['nama'] : '-';
        }

        $data = [
            'title' => 'Daftar Temuan',
            'temuan' => $temuan,
        ];

        echo view('layouts/header', $data);
        echo view('audit/temuan/tables.php', $data);
        echo view('layouts/footer');
    }

    public function update_temuan_status()
    {
        // Pastikan hanya menerima request AJAX
        if ($this->request->isAJAX()) { // Untuk CodeIgniter 4
            // if ($this->input->is_ajax_request()) { // Untuk CodeIgniter 3

            $id = $this->request->getPost('id');
            $status = $this->request->getPost('status');

            // Validasi input
            if (empty($id) || !in_array($status, ['0', '1', '2'])) {
                // Jika validasi gagal, kirimkan response error
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid ID atau status.'
                ]);
            }

            $model = new TemuanModel();
            $data = ['status' => $status];

            // Coba update data di database
            if ($model->update($id, $data)) {
                // Jika update berhasil, kirimkan response sukses
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Status berhasil diperbarui.'
                ]);
            } else {
                // Jika update gagal (misalnya karena ID tidak ditemukan), kirimkan response error
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui status di database.'
                ]);
            }
        } else {
            // Jika bukan request AJAX, kembalikan 404 Not Found
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(); // Untuk CodeIgniter 4
            // show_404(); // Untuk CodeIgniter 3
        }
    }

}