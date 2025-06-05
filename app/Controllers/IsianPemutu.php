<?php

namespace App\Controllers;

use App\Models\IsianPemutuModel;
use App\Models\UnitPemutuModel;
use App\Models\InstrumenPemutuModel;

class IsianPemutu extends BaseController
{
    protected $isianPemutuModel;
    protected $unitPemutuModel;
    protected $instrumenPemutuModel;

    public function __construct()
    {
        $this->isianPemutuModel = new IsianPemutuModel();
        $this->unitPemutuModel = new UnitPemutuModel();
        $this->instrumenPemutuModel = new InstrumenPemutuModel();
    }

    public function input()
    {
        // === AJAX Request: Get Instrumen berdasarkan Unit Pemutu ===
        if ($this->request->isAJAX() && $this->request->getPost('action') === 'get-instrumen') {
            try {
                $unitPemutuId = $this->request->getPost('id_unitpemutu');

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

                // Debug information
                $debugInfo = [
                    'unit_pemutu_id' => $unitPemutuId,
                    'lembaga_id' => $lembagaId,
                    'instrument_count' => count($instrumenList)
                ];

                if (empty($instrumenList)) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Tidak ada instrumen yang ditemukan untuk unit pemutu ini',
                        'data' => []
                    ]);
                }

                // Format data untuk response
                $formattedData = [];
                foreach ($instrumenList as $index => $instrumen) {
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
                    'data' => $formattedData
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

                if ($id) {
                    $this->isianPemutuModel->update($id, $data);
                    session()->setFlashdata('success', 'Data berhasil diperbarui!');
                } else {
                    $this->isianPemutuModel->save($data);
                    session()->setFlashdata('success', 'Data berhasil disimpan!');
                }

                return redirect()->to(site_url('akreditasi/isian-pemutu'));

            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
                return redirect()->back()->withInput();
            }
        }

        // === Mode Edit: Ambil data berdasarkan ID ===
        $editData = null;
        if ($this->request->getGet('id')) {
            $id = $this->request->getGet('id');
            $editData = $this->isianPemutuModel
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
            'title' => $editData ? "Edit Isian Pemutu" : "Input Isian Pemutu",
            'edit' => $editData,
            'unitpemutus' => $this->unitPemutuModel
                ->select('p_unit_pemutu.id, m_unit.nama as nama_unit, m_periode.ts as tahun_ajaran')
                ->join('m_unit', 'p_unit_pemutu.id_unit = m_unit.id')
                ->join('m_periode', 'p_unit_pemutu.id_periode = m_periode.id')
                ->findAll(),
            'instrumen_list' => [], // Akan diisi via AJAX
            'jenjang' => $this->instrumenPemutuModel->select('id, jenjang')->findAll()
        ];

        // Jika mode edit, ambil instrumen yang sesuai dengan unit pemutu yang dipilih
        if ($editData && !empty($editData['id_unitpemutu'])) {
            $data['instrumen_list'] = $this->instrumenPemutuModel->getByUnitPemutu($editData['id_unitpemutu']);
        }

        echo view('layouts/header.php', $data);
        echo view('akreditasi/isian_pemutu/form.php');
        echo view('layouts/footer.php');
    }

    public function index()
    {
        // Handle delete
        if ($this->request->getGet('delete')) {
            try {
                $id = $this->request->getGet('delete');
                $this->isianPemutuModel->delete($id);
                session()->setFlashdata('success', 'Data berhasil dihapus!');
            } catch (\Exception $e) {
                session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
            
            return redirect()->to(site_url('akreditasi/isian-pemutu'));
        }

        // Prepare data untuk view
        $data = [
            'title' => "Isian Pemutu",
            'isian_pemutu' => $this->isianPemutuModel->getJoin(),
            'periodeList' => $this->isianPemutuModel->getAllPeriode(),
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
        $isianRaw = $this->isianPemutuModel->getJoin();
        $data['isian_pemutu'] = array_map(function ($item) {
            $item['jenjang_text'] = $this->instrumenPemutuModel->getJenjangText($item['jenjang']);
            return $item;
        }, $isianRaw);

        echo view('layouts/header.php', $data);
        echo view('akreditasi/isian_pemutu/tables.php');
        echo view('layouts/footer.php');
    }
}