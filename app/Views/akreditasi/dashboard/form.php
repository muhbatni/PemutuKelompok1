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
      background: linear-gradient(135deg, #ffffff, #89CFF0, #ffffff);
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      padding: 25px;
      margin-bottom: 30px;
      transition: all 0.3s ease;
    }

    .dashboard-card:hover {
      transform: translateY(-3px);
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

    /* Dropdown Style */
    #filterTahun {
      border-radius: 8px;
      background-color: #ffffff;
      border: 1px solid #cbd5e1;
      padding: 10px;
    }

    /* Tabel Style */
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

    /* Badge Status */
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

    <!-- Dropdown Filter Tahun Periode -->
    <div class="dashboard-card">
      <label for="filterTahun" class="form-label">Filter Tahun Periode</label>
      <div class="input-group mb-3">
        <span class="input-group-text bg-white border-end-0">
          <i class="fas fa-calendar-alt text-primary"></i>
        </span>
        <select id="filterTahun" class="form-select border-start-0 custom-dropdown rounded-end"
          onchange="filterByTahun(this.value)">
          <option value="">-- Semua Tahun --</option>
          <?php if (!empty($periodeList)): ?>
            <?php foreach ($periodeList as $periode): ?>
              <option value="<?= esc($periode['id']) ?>" <?= ($selectedTahun == $periode['id']) ? 'selected' : '' ?>>
                <?= esc($periode['tahun']) ?> (<?= esc($periode['ts']) ?>)
              </option>
            <?php endforeach; ?>
          <?php else: ?>
            <option value="">Tidak ada data periode</option>
          <?php endif; ?>
        </select>
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
              <th>Kondisi</th>
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
                  <td><?= esc($row['kondisi']) ?></td>
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

  <!-- Script untuk filter tahun -->
  <script>
    function filterByTahun(tahun) {
      window.location.href = '<?= site_url('akreditasi/dashboard-periode') ?>?tahun=' + tahun;
    }
  </script>

</body>

</html>