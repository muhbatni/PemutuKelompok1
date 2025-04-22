<?php
$pesan = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id_unit = $_POST['id_unit'];
  $id_periode = $_POST['id_periode'];
  $id_lembaga = $_POST['id_lembaga'];
  $status = $_POST['status'];
  $created_at = date('Y-m-d H:i:s');
  $updated_at = date('Y-m-d H:i:s');

  // Konfigurasi koneksi database
  $host = "localhost";
  $dbname = "pemutu";     // Ganti dengan nama database kamu
  $user = "nama_user";           // Ganti dengan username PostgreSQL kamu
  $password = "adeerhans";        // Ganti dengan password PostgreSQL kamu

  // Koneksi ke PostgreSQL
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
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow rounded-4">
          <div class="card-body p-4">
            <h4 class="card-title mb-4 text-center">Form Input Data Pemutu</h4>

            <?php if (!empty($pesan))
              echo $pesan; ?>

            <form method="POST" action="">
              <div class="form-group m-form__group">
                <label for="id_unit">Unit</label>
                <select class="form-control m-input" id="id_unit" name="id_unit">
                  <option value="">-- Pilih Unit --</option>
                  <?php foreach ($units as $unit): ?>
                    <option value="<?= $unit['id']; ?>"><?= $unit['nama']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="id_periode" class="form-label">ID Periode</label>
                <input type="number" name="id_periode" class="form-control" required>
              </div>
              <div class="form-group m-form__group">
                <label for="id_lembaga">id_lembaga</label>
                <select class="form-control m-input" id="id_lembaga" name="id_lembaga">
                  <option value="">-- Pilih Unit --</option>
                  <?php foreach ($lembagas as $lembaga): ?>
                    <option value="<?= $lembaga['id']; ?>"><?= $lembaga['nama']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" required>
                  <option value="0">Aktif</option>
                  <option value="1">Nonaktif</option>
                </select>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary rounded-pill">Simpan Data</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>