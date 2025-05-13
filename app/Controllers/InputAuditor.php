<?php
namespace App\Controllers;

use App\Models\AuditorModel;
use App\Models\UserModel;

class InputAuditor extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();



        if ($this->request->getMethod() == 'POST') {
            $dokumen = $this->request->getFile('dokumen');

            if ($dokumen && $dokumen->isValid() && !$dokumen->hasMoved()) {
                // Lokasi upload di writable/uploads/dokumen/
                $uploadPath = WRITEPATH . 'uploads/audit/dokumen_auditor';

                // Bikin folder kalau belum ada
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Buat nama file acak supaya unik
                $newName = $dokumen->getRandomName();

                // Pindahkan file ke folder tujuan
                $dokumen->move($uploadPath, $newName);

                $id = $this->request->getPost('id');
                // Ini data lengkap untuk insert ke database
                $auditor = [
                    'id' => $id,
                    'dokumen' => $newName
                ];

                // Simpan ke database
                $auditorModel = new AuditorModel();
                $auditorModel->insert($auditor);

                return redirect()->to(base_url('public/audit/auditor'))->with('success', 'Data auditor berhasil disimpan.');

            } else {
                echo "Upload file tidak valid atau sudah dipindahkan.";
            }
        }

        $data["title"] = "Input Auditor";
        echo view('layouts/header.php', $data);
        echo view('audit/input_auditor/form.php', $data);
        echo view('layouts/footer.php');
    }

    public function edit($id)
    {
        if ($this->request->getMethod() === "POST") {
            $auditorModel = new AuditorModel();

            // Validasi input
            $validation = \Config\Services::validation();
            $validation->setRules([
                'dokumen' => 'permit_empty|uploaded[dokumen]|max_size[dokumen,2048]|ext_in[dokumen,pdf,doc,docx]'
            ]);

            if (!$this->validate($validation->getRules())) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            // Proses file dokumen
            $file = $this->request->getFile('dokumen');
            $newName = null;

            if ($file && !$file->isValid()) {
                return redirect()->to(base_url('public/audit/auditor'))->with('errors', 'File dokumen tidak valid.');
            }

            if (!$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/audit/dokumen_auditor', $newName);
            }

            // Data yang akan diperbarui
            $data = [
                'dokumen' => $newName,
            ];

            $auditorModel->update($id, $data);

            // Redirect dengan pesan sukses
            return redirect()->to(base_url('public/audit/auditor'))->with('success', 'Data auditor berhasil diperbarui.');
        }

        $auditorModel = new AuditorModel();
        $userModel = new UserModel();

        // Ambil data auditor berdasarkan ID
        $data['auditor'] = $auditorModel->find($id);

        // Ambil daftar user untuk dropdown
        $data['users'] = $userModel->findAll();

        if (!$data['auditor']) {
            return redirect()->to(base_url('public/audit/auditor'))->with('errors', ['Data auditor tidak ditemukan.']);
        }

        $data['title'] = 'Edit Auditor';

        // Tampilkan form dengan data yang sudah terisi
        echo view('layouts/header.php', $data);
        echo view('audit/input_auditor/form.php', $data);
        echo view('layouts/footer.php');
    }
    public function delete($id)
    {
        $auditorModel = new AuditorModel();

        // Cari data auditor berdasarkan ID
        $auditor = $auditorModel->find($id);

        if (!$auditor) {
            return redirect()->to(base_url('public/audit/auditor'))->with('errors', 'Data auditor tidak ditemukan.');
        }

        // Hapus file dokumen jika ada
        if (!empty($auditor['dokumen'])) {
            $filePath = WRITEPATH . 'uploads/audit/dokumen_auditor/' . $auditor['dokumen'];
            if (file_exists($filePath)) {
                unlink($filePath); // Hapus file dari server
            }
        }

        // Hapus data dari database
        $auditorModel->delete($id);

        // Redirect dengan pesan sukses
        return redirect()->to(base_url('public/audit/auditor'))->with('success', 'Data auditor berhasil dihapus.');
    }
    public function download($fileName)
    {
        $filePath = WRITEPATH . 'uploads/audit/dokumen_auditor/' . $fileName;

        if (file_exists($filePath)) {
            return $this->response->download($filePath, null)->setFileName($fileName);
        }

        return redirect()->to(base_url('public/audit/auditor'))->with('error', 'File tidak ditemukan!');
    }
}
?>