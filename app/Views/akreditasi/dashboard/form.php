<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Manajemen Penjaminan Mutu</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    /* Background Dashboard */
    body {
      background: linear-gradient(to bottom, #f4f7fc, #e9edf5);
      background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
    }

    /* Dashboard Card */
    .dashboard-card {
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      padding: 25px;
      margin-bottom: 30px;
      transition: all 0.3s ease;
    }

    /* Judul Besar */
    .page-title {
      font-weight: 700;
      font-size: 32px;
      color: #1e3a8a;
      margin-bottom: 40px;
      text-align: center;
    }

    /* Label Form */
    .form-label {
      font-weight: 600;
      color: #334155;
    }

    /* Search Input Style */
    .search-container {
      position: relative;
      margin-bottom: 15px;
    }

    .search-input {
      width: 100%;
      padding: 10px 15px 10px 40px;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      background-color: white;
    }

    .search-input:focus {
      outline: none;
      border-color: #6366f1;
      box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
    }

    .search-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #64748b;
    }

    /* Tabel Style - TAMPILAN ASLI */
    .table {
      background-color: white;
      border-radius: 12px;
      overflow: hidden;
    }

    .table thead {
      background: #e2e8f0;
      color: #334155;
    }

    .table-striped>tbody>tr:nth-of-type(odd) {
      background-color: #f8fafc;
    }

    .table-bordered td,
    .table-bordered th {
      border-color: #cbd5e1;
    }

    .table tbody tr:hover {
      background-color: #f1f5f9;
      transition: all 0.2s;
    }

    /* Badge Status - TAMPILAN ASLI */
    .badge-status {
      padding: 2px 6px;
      font-size: 0.85rem;
      border-radius: 5px;
      color: #ffffff;
      font-weight: 500;
    }

    .badge-cek {
      color: #6366f1;
      font-family: 'Poppins';
      font-weight: bold;
      font-size: 1rem;
    }

    .badge-lolos {
      color: #15803d;
      font-family: 'Poppins';
      font-weight: bold;
      font-size: 1rem;
    }

    .badge-peringatan {
      color: #FFBF00;
      font-family: 'Poppins';
      font-weight: bold;
      font-size: 1rem;
    }

    .badge-tidaklolos {
      color: #B22222;
      font-family: 'Poppins';
      font-weight: bold;
      font-size: 1rem;
    }

    .badge-belum {
      color: #64748b;
      font-family: 'Poppins';
      font-weight: bold;
      font-size: 1rem;
    }

    @media (max-width: 768px) {
      .page-title {
        font-size: 26px;
      }
    }
  </style>
</head>

<body>

  <div class="container">
    <h1 class="page-title">Dashboard Manajemen Penjaminan Mutu</h1>

    <!-- Search Input for Year Filter -->
    <div class="dashboard-card">
      <label for="yearFilter" class="form-label">Filter Tahun Periode</label>
      <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="yearFilter" class="search-input" placeholder="Ketik tahun (contoh: 2025, 2024/2025)"
          autocomplete="off">
      </div>
    </div>

   <!-- Tabel Data Unit Pemutu -->
   <div class="dashboard-card">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="fas fa-table text-primary me-2"></i>Data Unit Pemutu</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Unit</th>
              <th>Periode</th>
              <th>Status Isian</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($unitPemutu)): ?>
              <?php $no = 1; ?>
              <?php foreach ($unitPemutu as $row): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= esc($row['nama_unit']) ?></td>
                  <td><?= esc($row['periode']) ?> (<?= $row['ts'] ?>)</td>
                  <td>
                    <?php
                    $status = strtolower(trim($row['status_isian_text']));
                    $class = 'badge-status badge-belum';
                    if ($status == 'cek') {
                      $class = 'badge-status badge-cek';
                    } elseif ($status == 'lolos') {
                      $class = 'badge-status badge-lolos';
                    } elseif (strpos($status, 'peringatan') !== false) {
                      $class = 'badge-status badge-peringatan';
                    } elseif (strpos($status, 'tidak lolos') !== false) {
                      $class = 'badge-status badge-tidaklolos';
                    }
                    ?>
                    <span class="<?= $class ?>">
                      <?= esc($row['status_isian_text']) ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center">Tidak ada data</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Real-time Filtering Script -->
  <script>
    $(document).ready(function () {
      $('#yearFilter').on('input', function () {
        const searchTerm = $(this).val().toLowerCase().trim();

        $('#tableBody tr').each(function () {
          const $row = $(this);
          const yearText = $row.find('td:eq(2)').text().toLowerCase();

          if (yearText.includes(searchTerm) || searchTerm === '') {
            $row.show();
          } else {
            $row.hide();
          }
        });
      });
    });
  </script>

</body>

</html>