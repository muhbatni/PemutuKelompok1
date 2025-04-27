<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Penjaminan Mutu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .sidebar {
      height: 100vh;
      background-color: #343a40;
      color: #fff;
    }

    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 10px;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    /* Styling khusus untuk Dropdown */
    .custom-dropdown {
      background: #e9f2fd;
      /* Biru pastel muda */
      color: #212529;
      /* Text gelap */
      transition: background 0.4s ease, color 0.4s ease;
      border: 1px solid #ced4da;
      border-radius: 0 0.375rem 0.375rem 0;
    }

    /* Hover saat mouse mengarah ke select */
    .custom-dropdown:hover {
      background: linear-gradient(135deg, #0d6efd 0%, #20c997 100%);
      color: #ffffff;
      /* Saat hover text jadi putih */
    }

    /* Tampilan semua pilihan dalam dropdown */
    .custom-dropdown option {
      color: #212529;
      /* Warna teks tetap gelap */
      background: #ffffff;
      /* Background pilihan tetap putih */
    }

    /* Saat pilih salah satu option */
    .custom-dropdown:focus {
      border-color: #86b7fe;
      outline: 0;
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    }
  </style>
</head>

<body>
  <div class="col-md-10 mx-auto">
    <div class="p-4">
      <!-- Judul -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 text-dark fw-bold">Dashboard Manajemen Penjaminan Mutu</h3>
      </div>

      <!-- Dropdown Filter Tahun Periode -->
      <div class="mb-4">
        <label for="filterTahun" class="form-label fw-semibold text-dark">Filter Tahun Periode</label>
        <div class="input-group w-auto">
          <span class="input-group-text bg-white border-end-0">
            <i class="fas fa-calendar-alt text-primary"></i>
          </span>
          <select id="filterTahun" class="form-select border-start-0 custom-dropdown rounded-end">
            <option value="">-- Semua Tahun --</option>
            <?php if (!empty($periodeList)): ?>
              <?php foreach ($periodeList as $periode): ?>
                <option value="<?= esc($periode['tahun']) ?>">
                  <?= esc($periode['tahun']) ?> (<?= esc($periode['ts']) ?>)
                </option>
              <?php endforeach; ?>
            <?php else: ?>
              <option value="">Tidak ada data periode</option>
            <?php endif; ?>
          </select>
        </div>
      </div>

      <!-- Cards -->
      <div class="row mb-4">
        <div class="col-md-3">
          <div class="card text-white bg-primary mb-3 border-0 shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-clipboard-list me-2"></i>Total Evaluasi</h5>
              <p class="card-text fs-4 fw-bold" id="totalEvaluasi">150</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-success mb-3 border-0 shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-university me-2"></i>Unit Terlibat</h5>
              <p class="card-text fs-4 fw-bold" id="unitTerlibat">28</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-warning mb-3 border-0 shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-file-alt me-2"></i>Instrumen Aktif</h5>
              <p class="card-text fs-4 fw-bold" id="instrumenAktif">18</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-danger mb-3 border-0 shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-poll me-2"></i>Survey</h5>
              <p class="card-text fs-4 fw-bold" id="survey">10</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>