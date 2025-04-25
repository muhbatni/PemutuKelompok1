<?php
$pesan = session()->getFlashdata('pesan') ?? '';
$editData = session()->getFlashdata('editData') ?? null;
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Form Input Data Pemutu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .status-aktif {
      color: green;
      font-weight: bold;
    }

    .status-nonaktif {
      color: red;
      font-weight: bold;
    }

    /* Modal khusus untuk edit */
    .edit-modal .modal-content {
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
    }

    .edit-modal .modal-header {
      background-color: #f8f9fa;
      border-bottom: 1px solid #dee2e6;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .edit-modal .modal-title {
      font-weight: 600;
    }

    .edit-modal .modal-body {
      padding: 20px;
    }

    .edit-modal .form-label {
      font-weight: 500;
    }
  </style>
</head>

<body class="bg-light">
  <div class="container mt-4">
    <div class="row">
      <div class="col-lg-12">
        <div class="card shadow-sm p-4">
          <h4 class="mb-4">Form Input Data Pemutu</h4>
          <?php if (!empty($pesan))
            echo $pesan; ?>

          <form method="POST"
            action="<?= isset($editData) ? base_url('public/akreditasi/input-data-pemutu/update/' . $editData['id']) : base_url('public/akreditasi/input-data-pemutu/save') ?>">
            <?php if (isset($editData)): ?>
              <input type="hidden" name="_method" value="PUT">
            <?php endif; ?>

            <!-- Dropdown Unit -->
            <div class="mb-3">
              <label for="id_unit" class="form-label">Unit</label>
              <select class="form-select" id="id_unit" name="id_unit" required>
                <option value="">-- Pilih Unit --</option>
                <?php foreach ($units as $unit): ?>
                  <option value="<?= htmlspecialchars($unit['id']) ?>" <?= (isset($editData) && $editData['id_unit'] == $unit['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($unit['nama']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Dropdown Periode -->
            <div class="mb-3">
              <label for="id_periode" class="form-label">Periode (Tahun Ajaran)</label>
              <select class="form-select" id="id_periode" name="id_periode" required>
                <option value="">-- Pilih Periode --</option>
                <?php foreach ($periodes as $periode): ?>
                  <option value="<?= htmlspecialchars($periode['id']) ?>" <?= (isset($editData) && $editData['id_periode'] == $periode['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($periode['tahun']) ?> (<?= htmlspecialchars($periode['ts']) ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Dropdown Lembaga -->
            <div class="mb-3">
              <label for="id_lembaga" class="form-label">Lembaga</label>
              <select class="form-select" id="id_lembaga" name="id_lembaga" required>
                <option value="">-- Pilih Lembaga --</option>
                <?php foreach ($lembagas as $lembaga): ?>
                  <option value="<?= htmlspecialchars($lembaga['id']) ?>" <?= (isset($editData) && $editData['id_lembaga'] == $lembaga['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($lembaga['nama']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Dropdown Status -->
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select name="status" class="form-select" required>
                <option value="0" <?= ((isset($editData) && $editData['status'] == 0) ? 'selected' : '') ?>>Aktif</option>
                <option value="1" <?php if (isset($editData) && $editData['status'] == 1)
                  echo 'selected'; ?>>Nonaktif
                </option>
              </select>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-start mt-4">
              <button type="submit" class="btn btn-sm text-white me-2"
                style="background-color: #5867dd; border-color: #5867dd; padding: 6px 18px; font-size: 15px; line-height: 1.2; height: 32px; min-width: 80px;">
                <?= isset($editData) ? 'Perbarui Data' : 'Simpan' ?>
              </button>
              <?php if (isset($editData)): ?>
                <a href="<?= base_url('public/akreditasi/input-data-pemutu') ?>" class="btn btn-sm btn-light"
                  style="padding: 4px 12px; font-size: 0.8rem;">Batal</a>
              <?php endif; ?>
            </div>


          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Tabel Data Pemutu -->
  <div class="container mt-4">
    <div class="row">
      <div class="col-lg-12">
        <div class="card shadow-sm p-4">
          <h4 class="mb-4">Daftar Data Pemutu</h4>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead class="table-dark">
                <tr>
                  <th>No</th>
                  <th>Unit</th>
                  <th>Periode</th>
                  <th>Lembaga</th>
                  <th>Status</th>
                  <th>Tanggal Input</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($data_pemutu)): ?>
                  <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($data_pemutu as $index => $data): ?>
                    <tr>
                      <td><?= $index + 1 ?></td>
                      <td><?= htmlspecialchars($data['unit']) ?></td>
                      <td><?= htmlspecialchars($data['periode']) ?></td>
                      <td><?= htmlspecialchars($data['lembaga']) ?></td>
                      <td>
                        <span class="status-badge <?= $data['status'] == 0 ? 'status-aktif' : 'status-nonaktif' ?>">
                          <?= $data['status'] == 0 ? 'Aktif' : 'Nonaktif' ?>
                        </span>
                      </td>
                      <td><?= date('d/m/Y H:i', strtotime($data['created_at'])) ?></td>
                      <td>
                        <button class="btn btn-sm btn-warning edit-btn" data-id="<?= $data['id'] ?>"
                          data-id_unit="<?= isset($data['id_unit']) ? $data['id_unit'] : '' ?>"
                          data-id_lembaga="<?= isset($data['id_lembaga']) ? $data['id_lembaga'] : '' ?>"
                          data-status="<?= $data['status'] ?>">Edit</button>
                        <a href="<?= base_url('public/akreditasi/input-data-pemutu/delete/' . $data['id']) ?>"
                          class="btn btn-sm btn-danger"
                          onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Edit -->
  <div class="modal fade edit-modal" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Data Pemutu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" id="modal_id">

            <!-- Dropdown Unit -->
            <div class="mb-3">
              <label for="modal_id_unit" class="form-label">Unit</label>
              <select class="form-select" id="modal_id_unit" name="id_unit" required>
                <option value="">-- Pilih Unit --</option>
                <?php foreach ($units as $unit): ?>
                  <option value="<?= htmlspecialchars($unit['id']) ?>"><?= htmlspecialchars($unit['nama']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Dropdown Periode -->
            <div class="mb-3">
              <label for="modal_id_periode" class="form-label">Periode (Tahun Ajaran)</label>
              <select class="form-select" id="modal_id_periode" name="id_periode" required>
                <option value="">-- Pilih Periode --</option>
                <?php foreach ($periodes as $periode): ?>
                  <option value="<?= htmlspecialchars($periode['id']) ?>"><?= htmlspecialchars($periode['tahun']) ?>
                    (<?= htmlspecialchars($periode['ts']) ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Dropdown Lembaga -->
            <div class="mb-3">
              <label for="modal_id_lembaga" class="form-label">Lembaga</label>
              <select class="form-select" id="modal_id_lembaga" name="id_lembaga" required>
                <option value="">-- Pilih Lembaga --</option>
                <?php foreach ($lembagas as $lembaga): ?>
                  <option value="<?= htmlspecialchars($lembaga['id']) ?>"><?= htmlspecialchars($lembaga['nama']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Dropdown Status -->
            <div class="mb-3">
              <label for="modal_status" class="form-label">Status</label>
              <select name="status" class="form-select" id="modal_status" required>
                <option value="0">Aktif</option>
                <option value="1">Nonaktif</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="saveChanges">Simpan Perubahan</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Tangkap semua tombol edit
      const editButtons = document.querySelectorAll('.edit-btn');
      const editModal = new bootstrap.Modal(document.getElementById('editModal'));

      // Tangkap form edit
      const editForm = document.getElementById('editForm');

      // Tangkap tombol simpan di modal
      const saveChangesBtn = document.getElementById('saveChanges');

      // Untuk setiap tombol edit, tambahkan event listener
      editButtons.forEach(button => {
        button.addEventListener('click', function () {
          // Ambil data dari atribut data-*
          const id = this.getAttribute('data-id');
          const id_unit = this.getAttribute('data-id_unit');
          const id_periode = this.getAttribute('data-id_periode');
          const id_lembaga = this.getAttribute('data-id_lembaga');
          const status = this.getAttribute('data-status');

          // Isi form modal dengan data yang ada
          document.getElementById('modal_id').value = id;
          document.getElementById('modal_id_unit').value = id_unit;
          document.getElementById('modal_id_periode').value = id_periode;
          document.getElementById('modal_id_lembaga').value = id_lembaga;
          document.getElementById('modal_status').value = status;

          // Set action form
          editForm.action = `<?= base_url('public/akreditasi/input-data-pemutu/update/') ?>${id}`;

          // Tampilkan modal
          editModal.show();
        });
      });

      // Event listener untuk tombol simpan di modal
      saveChangesBtn.addEventListener('click', function () {
        // Submit form
        editForm.submit();
      });
    });
  </script>
</body>

</html>