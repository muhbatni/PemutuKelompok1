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
  <!-- <div class="container-fluid">
    <div class="row"> 
      
      <div class="col-md-2 sidebar p-3">
        <h5 class="text-center">Penjaminan Mutu</h5>
        <a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#"><i class="fas fa-database"></i> Data Pemutu</a>
        <a href="#"><i class="fas fa-file-alt"></i> Instrumen</a>
        <a href="#"><i class="fas fa-university"></i> Unit</a>
        <a href="#"><i class="fas fa-users"></i> Pengguna</a>
      </div> -->

  <!-- Main Content -->
  <div class="col-md-10">
    <div class="p-4">
      <h3 class="mb-4">Dashboard Manajemen Penjaminan Mutu</h3>

      <!-- Cards -->
      <div class="row mb-4">
        <div class="col-md-3">
          <div class="card text-white bg-primary mb-3">
            <div class="card-body">
              <h5 class="card-title">Total Evaluasi</h5>
              <p class="card-text fs-4">120</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-success mb-3">
            <div class="card-body">
              <h5 class="card-title">Unit Terlibat</h5>
              <p class="card-text fs-4">24</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-warning mb-3">
            <div class="card-body">
              <h5 class="card-title">Instrumen Aktif</h5>
              <p class="card-text fs-4">15</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-danger mb-3">
            <div class="card-body">
              <h5 class="card-title">Survey</h5>
              <p class="card-text fs-4">8</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Chart -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Rekap Evaluasi per Unit</h5>
          <canvas id="chartEvaluasi"></canvas>
        </div>
      </div>

    </div>
  </div>
  </div>
  </div>

  <script>
    const ctx = document.getElementById('chartEvaluasi').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Unit A', 'Unit B', 'Unit C', 'Unit D', 'Unit E'],
        datasets: [{
          label: 'Jumlah Evaluasi',
          data: [12, 19, 7, 10, 5],
          backgroundColor: '#0d6efd'
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</body>

</html>