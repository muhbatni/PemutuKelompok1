<?php
$pesan = session()->getFlashdata('pesan') ?? '';
$editData = $editData ?? null;
date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title><?= isset($editData) ? 'Edit' : 'Input' ?> Data Pemutu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
      color: #5e6278;
    }

    .status-aktif {
      color: green;
      font-weight: bold;
    }

    .status-nonaktif {
      color: red;
      font-weight: bold;
    }

    table thead th {
      background-color: #f9fafe;
      font-weight: 600;
      font-size: 14px;
      color: #5e6278;
      text-align: left;
      vertical-align: middle;
    }

    table tbody td {
      font-size: 14px;
      color: #5e6278;
      vertical-align: middle;
      text-align: left;
    }

    table tbody tr:nth-child(even) {
      background-color: #f9fafe;
    }

    table tbody tr:hover {
      background-color: #f1f3f9;
    }

    .card-header {
      background-color: #f9fafe;
      border-bottom: none;
    }

    .card {
      border: none;
      border-radius: 0.475rem;
      box-shadow: 0 0 20px rgba(76, 87, 125, 0.05);
    }

    /* Tombol Simpan */
    .btn-primary-custom {
      color: #fff;
      background-color: #5867dd;
      border: none;
    }

    .btn-primary-custom:hover {
      color: #000 !important;
      background-color: #4e5cc7 !important;
      border-color: #4e5cc7 !important;
    }

    .btn-primary-custom:active {
      color: #000 !important;
      background-color: #3d4ba8 !important;
      border-color: #3d4ba8 !important;
    }

    /* Tombol Edit */
    .btn-warning {
      color: #fff;
      background-color: #ffc107;
      border: none;
    }

    .btn-warning:hover {
      color: #000 !important;
      background-color: #e0a800 !important;
      border-color: #e0a800 !important;
    }

    .btn-warning:active {
      color: #000 !important;
      background-color: #d39e00 !important;
      border-color: #d39e00 !important;
    }

    /* Tombol Delete */
    .btn-danger {
      color: #fff;
      background-color: #f64e60;
      border: none;
    }

    .btn-danger:hover {
      color: #000 !important;
      background-color: #e04b5b !important;
      border-color: #e04b5b !important;
    }

    .btn-danger:active {
      color: #000 !important;
      background-color: #c53030 !important;
      border-color: #c53030 !important;
    }

    /* Tombol Batal */
    .btn-light-custom {
      background-color: #f9fafe;
      border: 1px solid #dcdfe6;
      color: #5e6278;
    }

    .btn-light-custom:hover {
      background-color: #e2e6ea;
      color: #000;
    }

    /* Tombol Simpan */
    .btn-primary-custom {
      background-color: #5867dd;
      border-color: #5867dd;
      padding: 10px 24px;
      font-size: 14px;
      line-height: 1.5;
      height: 40px;
      min-width: 100px;
      color: white;
    }

    .btn-primary-custom:hover {
      background-color: #4856c4;
      border-color: #4856c4;
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
                <option value="">-- Pilih Status --</option>
                <option value="0" <?= (isset($editData) && $editData['status'] == 0) ? 'selected' : '' ?>>Aktif</option>
                <option value="1" <?= (isset($editData) && $editData['status'] == 1) ? 'selected' : '' ?>>Nonaktif</option>
              </select>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-start mt-4">
              <button type="submit" class="btn btn-sm btn-primary-custom me-2">
                <?= isset($editData) ? 'Perbarui Data' : 'Simpan' ?>
              </button>
              <?php if (isset($editData)): ?>
                <a href="<?= base_url('public/akreditasi/input-data-pemutu') ?>" class="btn btn-sm btn-light-custom">
                  Batal
                </a>
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