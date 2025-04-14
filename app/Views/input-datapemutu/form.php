<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Input Data Pemutu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light py-5">

  <div class="container">
    <div class="card shadow-sm rounded-4">
      <div class="card-header bg-primary text-white rounded-top-4">
        <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Input Data Pemutu</h4>
      </div>
      <div class="card-body">

        <form>
          <div class="row g-3">

            <div class="col-md-6">
              <label for="id_unitpemutu" class="form-label">ID Unit Penjamin Mutu</label>
              <input type="number" class="form-control" id="id_unitpemutu" name="id_unitpemutu" placeholder="Contoh: 1"
                required>
            </div>

            <div class="col-md-6">
              <label for="id_instrumen" class="form-label">ID Instrumen</label>
              <input type="number" class="form-control" id="id_instrumen" name="id_instrumen" placeholder="Contoh: 3"
                required>
            </div>

            <div class="col-md-6">
              <label for="isian" class="form-label">Nilai Capaian (Isian)</label>
              <input type="number" class="form-control" id="isian" name="isian" step="0.01" placeholder="Contoh: 87.5"
                required>
            </div>

            <div class="col-md-6">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" id="status" name="status" required>
                <option selected disabled>-- Pilih Status --</option>
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
              </select>
            </div>

          </div>

          <div class="mt-4 d-flex justify-content-end">
            <button type="reset" class="btn btn-outline-secondary me-2">Reset</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Bootstrap Icon -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>

</html>