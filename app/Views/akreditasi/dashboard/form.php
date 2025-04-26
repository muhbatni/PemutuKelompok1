<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Penjaminan Mutu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
  </style>
</head>

<body>
  <div class="col-md-10">
    <div class="p-4">
      <!-- Judul -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 text-dark fw-bold">Dashboard Manajemen Penjaminan Mutu</h3>
      </div>

      <!-- Dropdown Filter Tahun Periode -->
      <div class="mb-4">
        <label for="filterTahun" class="form-label fw-semibold text-dark">Filter Tahun Periode</label>
        <select id="filterTahun" class="form-select w-auto">
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

      <!-- Chart -->
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <h5 class="card-title text-dark fw-bold"><i class="fas fa-chart-bar me-2"></i>Rekap Evaluasi per Unit</h5>
          <canvas id="chartEvaluasi"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Contoh data chart
    const data = {
      labels: ['Unit A', 'Unit B', 'Unit C', 'Unit D', 'Unit E', 'Unit F'],
      data: [15, 22, 10, 12, 8, 5],
      colors: ['#6a11cb', '#2575fc', '#4facfe', '#00f2fe', '#a6c1ee', '#fbc2eb']
    };

    const ctx = document.getElementById('chartEvaluasi').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: data.labels,
        datasets: [{
          label: 'Jumlah Evaluasi',
          data: data.data,
          backgroundColor: data.colors,
          borderColor: 'rgba(255, 255, 255, 0.8)',
          borderWidth: 1,
          borderRadius: 8,
          hoverBackgroundColor: data.colors.map(color => `${color}CC`),
          hoverBorderWidth: 2
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleFont: { size: 14, weight: 'bold' },
            bodyFont: { size: 12 },
            padding: 12,
            cornerRadius: 10,
            displayColors: true,
            boxPadding: 5
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(0, 0, 0, 0.05)' },
            ticks: { font: { weight: 'bold' } }
          },
          x: {
            grid: { display: false },
            ticks: { font: { weight: 'bold' } }
          }
        }
      }
    });
  </script>
</body>

</html>