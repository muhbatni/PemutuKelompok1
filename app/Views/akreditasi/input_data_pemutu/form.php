<?php
$pesan = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_unit = $_POST['id_unit'];
  $id_periode = $_POST['id_periode'];
  $id_lembaga = $_POST['id_lembaga'];
  $status = $_POST['status'];
  $created_at = date('Y-m-d H:i:s');
  $updated_at = date('Y-m-d H:i:s');

  $host = "localhost";
  $dbname = "pemutu";
  $user = "postgres";
  $password = "adeerhans";

  $conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

  if (!$conn) {
    $pesan = "Koneksi ke database gagal.";
  } else {
    $query = "INSERT INTO p_unit_pemutu (id_unit, id_periode, id_lembaga, status, created_at, updated_at) 
              VALUES ($1, $2, $3, $4, $5, $6)";
    $result = pg_query_params($conn, $query, array(
      $id_unit,
      $id_periode,
      $id_lembaga,
      $status,
      $created_at,
      $updated_at
    ));

    if ($result) {
      $pesan = "<div class='alert alert-success'>✅ Data berhasil disimpan.</div>";
    } else {
      $pesan = "<div class='alert alert-danger'>❌ Gagal menyimpan data: " . pg_last_error($conn) . "</div>";
    }

    pg_close($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Form Input Data Pemutu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container mt-4">
    <div class="row">
      <div class="col-lg-12">
        <div class="card shadow-sm p-4">
          <h4 class="mb-4">Form Input Data Pemutu</h4>

          <?php if (!empty($pesan))
            echo $pesan; ?>

          <form method="POST" action="">
            <!-- Dropdown Unit -->
            <div class="mb-3">
              <label for="id_unit" class="form-label">Unit</label>
              <select class="form-select <?= session('errors.id_unit') ? 'is-invalid' : '' ?>" id="id_unit"
                name="id_unit" required>
                <option value="">-- Pilih Unit --</option>
                <?php foreach ($units as $unit): ?>
                  <option value="<?= $unit['id'] ?>" <?= old('id_unit') == $unit['id'] ? 'selected' : '' ?>>
                    <?= esc($unit['nama']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <?php if (session('errors.id_unit')): ?>
                <div class="invalid-feedback">
                  <?= session('errors.id_unit') ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- Dropdown Periode -->
            <div class="mb-3">
              <label for="id_periode" class="form-label">Periode (Tahun Ajaran)</label>
              <select class="form-select <?= session('errors.id_periode') ? 'is-invalid' : '' ?>" id="id_periode"
                name="id_periode" required>
                <option value="">-- Pilih Periode --</option>
                <?php foreach ($periodes as $periode): ?>
                  <option value="<?= $periode['id'] ?>" <?= old('id_periode') == $periode['id'] ? 'selected' : '' ?>>
                    <?= esc($periode['tahun']) ?> (<?= esc($periode['ts']) ?>)
                  </option>
                <?php endforeach; ?>
              </select>
              <?php if (session('errors.id_periode')): ?>
                <div class="invalid-feedback">
                  <?= session('errors.id_periode') ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- Dropdown Lembaga -->
            <div class="mb-3">
              <label for="id_lembaga" class="form-label">Lembaga</label>
              <select class="form-select <?= session('errors.id_lembaga') ? 'is-invalid' : '' ?>" id="id_lembaga"
                name="id_lembaga" required>
                <option value="">-- Pilih Lembaga --</option>
                <?php foreach ($lembagas as $lembaga): ?>
                  <option value="<?= $lembaga['id'] ?>" <?= old('id_lembaga') == $lembaga['id'] ? 'selected' : '' ?>>
                    <?= esc($lembaga['nama']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <?php if (session('errors.id_lembaga')): ?>
                <div class="invalid-feedback">
                  <?= session('errors.id_lembaga') ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- Dropdown Status -->
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select name="status" class="form-select <?= session('errors.status') ? 'is-invalid' : '' ?>" required>
                <option value="0" <?= old('status') == '0' ? 'selected' : '' ?>>Aktif</option>
                <option value="1" <?= old('status') == '1' ? 'selected' : '' ?>>Nonaktif</option>
              </select>
              <?php if (session('errors.status')): ?>
                <div class="invalid-feedback">
                  <?= session('errors.status') ?>
                </div>
              <?php endif; ?>
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Tabel Data Pemutu -->
  <div class="row mt-4">
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
                      <a href="#" class="btn btn-sm btn-warning">Edit</a>
                      <a href="#" class="btn btn-sm btn-danger">Hapus</a>
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