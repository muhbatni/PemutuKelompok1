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

    /* Beautiful dropdown styling */
    .period-filter {
      position: relative;
      z-index: 1000;
    }

    .period-filter .btn-period {
      background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 30px;
      font-weight: 500;
      box-shadow: 0 4px 15px rgba(106, 17, 203, 0.3);
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .period-filter .btn-period:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(106, 17, 203, 0.4);
    }

    .period-filter .btn-period:active {
      transform: translateY(0);
    }

    .period-filter .dropdown-menu {
      border: none;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      padding: 0;
      margin-top: 10px;
    }

    .period-filter .dropdown-item {
      padding: 10px 20px;
      transition: all 0.3s ease;
      position: relative;
      font-weight: 500;
    }

    .period-filter .dropdown-item:not(:last-child) {
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .period-filter .dropdown-item:hover {
      background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
      color: #2575fc;
      padding-left: 25px;
    }

    .period-filter .dropdown-item:hover::before {
      content: "";
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      width: 5px;
      height: 5px;
      background-color: #2575fc;
      border-radius: 50%;
    }

    .period-filter .dropdown-item.active {
      background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
      color: white;
    }

    /* Animation for dropdown */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .period-filter .dropdown-menu.show {
      animation: fadeIn 0.3s ease forwards;
    }
  </style>
</head>

<body>
  <div class="col-md-10">
    <div class="p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 text-dark fw-bold">Dashboard Manajemen Penjaminan Mutu</h3>
        <div class="dropdown period-filter">
          <button class="btn btn-period dropdown-toggle" type="button" id="yearDropdown" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class="fas fa-calendar-alt"></i>
            <span id="selectedYearText">Pilih Periode Tahun</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="yearDropdown" id="yearList">
            <!-- Years will be populated by JavaScript -->
          </ul>
        </div>
      </div>

      <!-- Cards -->
      <div class="row mb-4">
        <div class="col-md-3">
          <div class="card text-white bg-primary mb-3 border-0 shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-clipboard-list me-2"></i>Total Evaluasi</h5>
              <p class="card-text fs-4 fw-bold" id="totalEvaluasi">120</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-success mb-3 border-0 shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-university me-2"></i>Unit Terlibat</h5>
              <p class="card-text fs-4 fw-bold" id="unitTerlibat">24</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-warning mb-3 border-0 shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-file-alt me-2"></i>Instrumen Aktif</h5>
              <p class="card-text fs-4 fw-bold" id="instrumenAktif">15</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card text-white bg-danger mb-3 border-0 shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-poll me-2"></i>Survey</h5>
              <p class="card-text fs-4 fw-bold" id="survey">8</p>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Sample data structure that would come from your backend
    const periodData = {
      // This would be fetched from your database (m_periode table)
      availableYears: [2024, 2023],

      // Sample data for each period
      periodStats: {
        2023: {
          totalEvaluasi: 120,
          unitTerlibat: 24,
          instrumenAktif: 15,
          survey: 8,
          chartData: {
            labels: ['Unit A', 'Unit B', 'Unit C', 'Unit D', 'Unit E'],
            data: [12, 19, 7, 10, 5],
            colors: ['#6a11cb', '#2575fc', '#4facfe', '#00f2fe', '#a6c1ee']
          }
        },
        2024: {
          totalEvaluasi: 150,
          unitTerlibat: 28,
          instrumenAktif: 18,
          survey: 10,
          chartData: {
            labels: ['Unit A', 'Unit B', 'Unit C', 'Unit D', 'Unit E', 'Unit F'],
            data: [15, 22, 10, 12, 8, 5],
            colors: ['#6a11cb', '#2575fc', '#4facfe', '#00f2fe', '#a6c1ee', '#fbc2eb']
          }
        }
      }
    };

    // Initialize chart
    let evaluationChart;
    const ctx = document.getElementById('chartEvaluasi').getContext('2d');

    function initializeChart(year) {
      const data = periodData.periodStats[year];

      if (evaluationChart) {
        evaluationChart.destroy();
      }

      evaluationChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.chartData.labels,
          datasets: [{
            label: 'Jumlah Evaluasi',
            data: data.chartData.data,
            backgroundColor: data.chartData.colors,
            borderColor: 'rgba(255, 255, 255, 0.8)',
            borderWidth: 1,
            borderRadius: 8,
            hoverBackgroundColor: data.chartData.colors.map(color => `${color}CC`),
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
              titleFont: {
                size: 14,
                weight: 'bold'
              },
              bodyFont: {
                size: 12
              },
              padding: 12,
              cornerRadius: 10,
              displayColors: true,
              boxPadding: 5
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                color: 'rgba(0, 0, 0, 0.05)'
              },
              ticks: {
                font: {
                  weight: 'bold'
                }
              }
            },
            x: {
              grid: {
                display: false
              },
              ticks: {
                font: {
                  weight: 'bold'
                }
              }
            }
          }
        }
      });
    }

    // Populate year dropdown
    const yearList = document.getElementById('yearList');
    periodData.availableYears.forEach(year => {
      const li = document.createElement('li');
      const a = document.createElement('a');
      a.className = 'dropdown-item';
      a.href = '#';
      a.innerHTML = `<i class="fas fa-calendar me-2"></i> ${year}`;
      a.addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('selectedYearText').textContent = `Tahun ${year}`;

        // Update active state
        document.querySelectorAll('.dropdown-item').forEach(item => {
          item.classList.remove('active');
        });
        a.classList.add('active');

        updateDashboard(year);
      });
      li.appendChild(a);
      yearList.appendChild(li);
    });

    // Function to update dashboard data
    function updateDashboard(year) {
      const data = periodData.periodStats[year];

      document.getElementById('totalEvaluasi').textContent = data.totalEvaluasi;
      document.getElementById('unitTerlibat').textContent = data.unitTerlibat;
      document.getElementById('instrumenAktif').textContent = data.instrumenAktif;
      document.getElementById('survey').textContent = data.survey;

      initializeChart(year);
    }

    // Initialize with first available year
    if (periodData.availableYears.length > 0) {
      const firstYear = periodData.availableYears[0];
      document.getElementById('selectedYearText').textContent = `Tahun ${firstYear}`;
      document.querySelector('.dropdown-item').classList.add('active');
      updateDashboard(firstYear);
    }
  </script>
</body>

</html>