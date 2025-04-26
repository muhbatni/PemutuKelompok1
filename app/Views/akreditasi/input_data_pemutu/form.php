<?php
$pesan = session()->getFlashdata('pesan') ?? '';
$editData = session()->getFlashdata('editData') ?? null;
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title><?= isset($editData) ? 'Edit' : 'Input' ?> Data Pemutu</title>
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
  </style>
</head>

<body class="bg-light">
  <div class="container mt-4">
    <div class="row">
      <div class="col-lg-12">
        <div class="card shadow-sm p-4">
          <h4 class="mb-4"><?= isset($editData) ? 'Edit' : 'Form Input' ?> Data Pemutu</h4>
          <?php if (!empty($pesan))
            echo $pesan; ?>

          <form method="POST"
            action="<?= isset($editData) ? base_url('public/akreditasi/input-data-pemutu/update/' . $editData['id']) : base_url('public/akreditasi/input-data-pemutu/save') ?>">
            <?php if (isset($editData)): ?>
              <input type="hidden" name="_method">
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
                <option value="0" <?= (isset($editData) && $editData['status'] == 0) ? 'selected' : '' ?>>Aktif</option>
                <option value="1" <?= (isset($editData) && $editData['status'] == 1) ? 'selected' : '' ?>>Nonaktif</option>

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
  <div class="row mt-5">
    <div class="col-md-12">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
          <h5 class="mb-0">Daftar Data Pemutu</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table align-middle mb-0">
              <thead class="bg-light">
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
                        <a href="<?= base_url('public/akreditasi/input-data-pemutu/edit/' . $data['id']) ?>"
                          class="btn btn-sm btn-warning">Edit</a>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>