<?php

namespace App\Controllers;

use App\Models\IsianPemutuUnitModel;
use App\Models\UnitPemutuModel;
use App\Models\InstrumenPemutuModel;

class IsianPemutuUnit extends BaseController
{
    protected $isianPemutuUnitModel;
    protected $unitPemutuModel;
    protected $instrumenPemutuModel;
    protected $userModel;

    public function __construct()
    {
        $this->isianPemutuUnitModel = new IsianPemutuUnitModel();
        $this->unitPemutuModel = new UnitPemutuModel();
        $this->instrumenPemutuModel = new InstrumenPemutuModel();
        $this->userModel = new \App\Models\UserModel();
    }

    public function input()
    {
        $unit = $this->userModel->getUnit() ?: "null";

        // === AJAX Request: Get Instrumen berdasarkan Unit Pemutu ===
        if ($this->request->isAJAX() && $this->request->getPost('action') === 'get-instrumen') {
            try {
                $unitPemutuId = $this->request->getPost('id_unitpemutu');
                $editId = $this->request->getPost('edit_id'); // ID data yang sedang diedit (jika ada)

                if (empty($unitPemutuId)) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'ID Unit Pemutu tidak boleh kosong',
                        'data' => []
                    ]);
                }

                $lembagaId = $this->instrumenPemutuModel->getLembagaByUnitPemutu($unitPemutuId);
        
                // Ambil instrumen berdasarkan unit pemutu
                $instrumenList = $this->instrumenPemutuModel->getByUnitPemutu($unitPemutuId);

                // Ambil instrumen yang sudah digunakan untuk unit pemutu ini
                $usedInstrumenIds = $this->isianPemutuUnitModel->getUsedInstrumenByUnitPemutu($unitPemutuId, $editId);

                // Debug information
                $debugInfo = [
                    'unit_pemutu_id' => $unitPemutuId,
                    'lembaga_id' => $lembagaId,
                    'instrument_count' => count($instrumenList),
                    'used_instruments' => $usedInstrumenIds,
                    'edit_id' => $editId
                ];

                if (empty($instrumenList)) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Tidak ada instrumen yang ditemukan untuk unit pemutu ini',
                        'data' => []
                    ]);
                }

                // Filter instrumen yang belum digunakan
                $availableInstrumen = array_filter($instrumenList, function($instrumen) use ($usedInstrumenIds) {
                    return !in_array($instrumen['id'], $usedInstrumenIds);
                });

                // Jika tidak ada instrumen yang tersedia
                if (empty($availableInstrumen)) {
                    return $this->response->setJSON([
                        'status' => 'warning',
                        'message' => 'Semua instrumen untuk unit pemutu ini sudah digunakan',
                        'data' => []
                    ]);
                }

                // Format data untuk response
                $formattedData = [];
                foreach ($availableInstrumen as $index => $instrumen) {
                    $formattedData[] = [
                        'id' => $instrumen['id'],
                        'text' => ($index + 1) . ' - ' . $instrumen['nama_lembaga'] . ' - ' . $instrumen['indikator'],
                        'nama_lembaga' => $instrumen['nama_lembaga'],
                        'jenjang' => $instrumen['jenjang'],
                        'indikator' => $instrumen['indikator'],
                        'kondisi' => $instrumen['kondisi'],
                        'batas' => $instrumen['batas']
                    ];
                }

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Data berhasil dimuat',
                    'data' => $formattedData,
                    'debug' => $debugInfo // Untuk debugging, bisa dihapus di production
                ]);

            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                    'data' => []
                ]);
            }
        }

        // === POST Request: Simpan / Update data ===
        if ($this->request->getMethod() === 'POST') {
            try {
                $id = $this->request->getPost('id');
                $data = [
                    'id_unitpemutu' => $this->request->getPost('id_unitpemutu'),
                    'id_instrumen' => $this->request->getPost('id_instrumen'),
                    'isian' => $this->request->getPost('isian'),
                    'status' => $this->request->getPost('status'),
                ];

                // Validasi data
                if (empty($data['id_unitpemutu']) || empty($data['id_instrumen'])) {
                    session()->setFlashdata('error', 'Unit Pemutu dan Instrumen harus dipilih!');
                    return redirect()->back()->withInput();
                }

                if (!is_numeric($data['isian']) || $data['isian'] === '') {
                    session()->setFlashdata('error', 'Isian harus diisi dengan angka!');
                    return redirect()->back()->withInput();
                }

                if (!in_array($data['status'], [0, 1])) {
                    session()->setFlashdata('error', 'Status tidak valid!');
                    return redirect()->back()->withInput();
                }

                // Validasi duplikasi instrumen untuk unit pemutu yang sama
                if (!$id) { // Hanya untuk data baru
                    $existingData = $this->isianPemutuUnitModel
                        ->where('id_unitpemutu', $data['id_unitpemutu'])
                        ->where('id_instrumen', $data['id_instrumen'])
                        ->first();

                    if ($existingData) {
                        session()->setFlashdata('error', 'Instrumen ini sudah digunakan untuk unit pemutu yang dipilih!');
                        return redirect()->back()->withInput();
                    }
                }

                if ($id) {
                    // Untuk update, pastikan tidak ada duplikasi dengan data lain
                    $existingData = $this->isianPemutuUnitModel
                        ->where('id_unitpemutu', $data['id_unitpemutu'])
                        ->where('id_instrumen', $data['id_instrumen'])
                        ->where('id !=', $id)
                        ->first();

                    if ($existingData) {
                        session()->setFlashdata('error', 'Instrumen ini sudah digunakan untuk unit pemutu yang dipilih!');
                        return redirect()->back()->withInput();
                    }

                    $this->isianPemutuUnitModel->update($id, $data);
                    session()->setFlashdata('success', 'Data berhasil diperbarui!');
                } else {
                    $this->isianPemutuUnitModel->save($data);
                    session()->setFlashdata('success', 'Data berhasil disimpan!');
                }

                return redirect()->to(site_url('akreditasi/isian-pemutu-unit'));

            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
                return redirect()->back()->withInput();
            }
        }

        // === Mode Edit: Ambil data berdasarkan ID ===
        $editData = null;
        if ($this->request->getGet('id')) {
            $id = $this->request->getGet('id');
            $editData = $this->isianPemutuUnitModel
                ->select('p_isian_pemutu.*, p_instrumen_pemutu.jenjang')
                ->join('p_instrumen_pemutu', 'p_instrumen_pemutu.id = p_isian_pemutu.id_instrumen')
                ->where('p_isian_pemutu.id', $id)
                ->first();

            if ($editData) {
                log_message('debug', 'Edit data: ' . json_encode($editData));
            }
        }

        // === Prepare data untuk view ===
        $data = [
            'title' => $editData ? "Edit Isian Pemutu Unit" : "Input Isian Pemutu Unit",
            'edit' => $editData,
            'unitpemutus' => $this->unitPemutuModel
                ->select('p_unit_pemutu.id, m_unit.nama as nama_unit, m_periode.ts as tahun_ajaran')
                ->join('m_unit', 'p_unit_pemutu.id_unit = m_unit.id')
                ->join('m_periode', 'p_unit_pemutu.id_periode = m_periode.id')
                ->like('m_unit.nama', $unit) // Filter berdasarkan nama unit login
                ->findAll(),
            'instrumen_list' => [], // Akan diisi via AJAX
            'jenjang' => $this->instrumenPemutuModel->select('id, jenjang')->findAll()
        ];

        // Jika mode edit, ambil instrumen yang sesuai dengan unit pemutu yang dipilih
        if ($editData && !empty($editData['id_unitpemutu'])) {
            $data['instrumen_list'] = $this->instrumenPemutuModel->getByUnitPemutu($editData['id_unitpemutu']);
        }

        echo view('layouts/header.php', $data);
        echo view('akreditasi/isian_pemutu_unit/form.php');
        echo view('layouts/footer.php');
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $unit = $this->userModel->getUnit() ?: "null";

        // Handle delete
        if ($this->request->getGet('delete')) {
            try {
                $id = $this->request->getGet('delete');
                $this->isianPemutuUnitModel->delete($id);
                session()->setFlashdata('success', 'Data berhasil dihapus!');
            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
            
            return redirect()->to(site_url('akreditasi/isian-pemutu-unit'));
        }

        // Prepare data untuk view
        $data = [
            'title' => "Isian Pemutu Unit",
            'isian_pemutu' => $this->isianPemutuUnitModel->getJoin(),
            'periodeList' => $this->isianPemutuUnitModel->getAllPeriode(),
            'nama_unit_login' => esc($unit),
            'unitpemutus' => $this->unitPemutuModel
                ->select('p_unit_pemutu.id, m_unit.nama as nama_unit, m_periode.ts as tahun_ajaran')
                ->join('m_unit', 'p_unit_pemutu.id_unit = m_unit.id')
                ->join('m_periode', 'p_unit_pemutu.id_periode = m_periode.id')
                ->findAll(),
            'instrumen_list' => $this->instrumenPemutuModel->getWithLembaga(),
            'jenjang' => $this->instrumenPemutuModel->select('id, jenjang')->findAll(),
            'instrumenPemutuModel' => $this->instrumenPemutuModel
        ];

        // Format data tabel dengan jenjang text
        $isianRaw = $this->isianPemutuUnitModel->getJoin();
        $data['isian_pemutu'] = array_map(function ($item) {
            $item['jenjang_text'] = $this->instrumenPemutuModel->getJenjangText($item['jenjang']);
            return $item;
        }, $isianRaw);

        echo view('layouts/header.php', $data);
        echo view('akreditasi/isian_pemutu_unit/tables.php');
        echo view('layouts/footer.php');
    }
}
