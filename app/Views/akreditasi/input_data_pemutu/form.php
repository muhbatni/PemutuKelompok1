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

    .btn-light-custom {
      background-color: #f1f3f9;
      border: 1px solid #dcdfe6;
      color: #5e6278;
      padding: 10px 24px;
      font-size: 14px;
      line-height: 1.5;
      height: 40px;
      min-width: 100px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .btn-light-custom:hover {
      background-color: #e2e6ea;
      color: #000000;
    }

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

    .form-control-plaintext {
      display: flex;
      align-items: center;
      padding: 0 0.75rem;
      height: 38px;
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      background-color: #ffffff;
    }


    /* Perbaikan warna background lembaga agar putih */
    #lembaga_display.form-control-plaintext {
      background-color: #fff !important;
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

            <!-- Text Lembaga -->
            <div class="mb-3">
              <label for="lembaga_display" class="form-label">Lembaga</label>
              <div id="lembaga_display" class="form-control-plaintext">-</div>
              <input type="hidden" name="id_lembaga" id="id_lembaga"
                value="<?= isset($editData) ? $editData['id_lembaga'] : '' ?>">
            </div>

            <!-- Text Status -->
            <div class="mb-3">
              <label for="status_display" class="form-label">Status</label>
              <div id="status_display" class="form-control-plaintext"></div>
              <input type="hidden" name="status" id="status_input"
                value="<?= isset($editData) ? $editData['status'] : '' ?>">
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-start mt-4">
              <button type="submit" class="btn btn-sm btn-primary-custom me-2">
                <?= isset($editData) ? 'Perbarui Data' : 'Simpan' ?>
              </button>
              <a href="<?= base_url('public/akreditasi/input-data-pemutu') ?>" class="btn btn-sm btn-light-custom">
                Batal
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
function updateLembaga(unitId) {
    const lembagaDisplay = document.getElementById('lembaga_display');
    const idLembagaInput = document.getElementById('id_lembaga');

    if (!unitId) {
        lembagaDisplay.textContent = '-';
        idLembagaInput.value = '';
        return;
    }

    fetch(`<?= base_url('public/akreditasi/input-data-pemutu/get-lembaga') ?>/${unitId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                lembagaDisplay.textContent = '-';
                idLembagaInput.value = '';
            } else {
                lembagaDisplay.textContent = data.nama;
                idLembagaInput.value = data.id;
            }
        })
        .catch(() => {
            lembagaDisplay.textContent = '-';
            idLembagaInput.value = '';
        });
}

// Event listener untuk perubahan unit
document.getElementById('id_unit').addEventListener('change', function() {
    updateLembaga(this.value);
});

// Set lembaga saat halaman dimuat jika dalam mode edit
<?php if (isset($editData)): ?>
document.addEventListener('DOMContentLoaded', function() {
    const unitSelect = document.getElementById('id_unit');
    const lembagaDisplay = document.getElementById('lembaga_display');
    
    // Set nilai awal lembaga jika ada
    if ('<?= $editData['lembaga_nama'] ?? '' ?>' !== '') {
        lembagaDisplay.textContent = '<?= $editData['lembaga_nama'] ?>';
    }
    
    // Trigger change event untuk memperbarui lembaga
    updateLembaga(unitSelect.value);
});
<?php endif; ?>

    <?php if (isset($editData)): ?>
      document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('id_unit').dispatchEvent(new Event('change'));
      });
    <?php endif; ?>

    // Tambahkan di dalam tag <script> yang sudah ada
   function updateStatus(data) {
    const statusDisplay = document.getElementById('status_display');
    const statusInput = document.getElementById('status_input');

    if (data.total_isian === 0) {
        statusDisplay.textContent = '-';
        statusDisplay.className = 'form-control-plaintext';
        statusInput.value = '';
        return;
    }

    const percentage = data.percentage || Math.round((data.jumlah_lolos / data.total_isian) * 100);
    let statusText, statusClass;

    if (percentage >= 60) {
        statusText = `Lolos (${percentage}%)`;
        statusClass = 'text-success';
    } else if (percentage >= 50) {
        statusText = `Peringatan (${percentage}%)`;
        statusClass = 'text-warning';
    } else {
        statusText = `Tidak Lolos (${percentage}%)`;
        statusClass = 'text-danger';
    }

    statusDisplay.textContent = statusText;
    statusDisplay.className = `form-control-plaintext ${statusClass}`;
    statusInput.value = statusText;
}

    // Modifikasi event listener unit untuk mengambil data status
    document.getElementById('id_unit').addEventListener('change', function () {
      const unitId = this.value;
      const periodeId = document.getElementById('id_periode').value;

      if (unitId && periodeId) {
        fetch(`<?= site_url('akreditasi/input-data-pemutu/get-status') ?>/${unitId}/${periodeId}`)
          .then(response => response.json())
          .then(data => {
            updateStatus(data);
          })
          .catch(() => {
            updateStatus({
              total_isian: 0,
              jumlah_lolos: 0,
              percentage: 0
            });
          });
      } else {
        updateStatus({
          total_isian: 0,
          jumlah_lolos: 0,
          percentage: 0
        });
      }
    });

    // Tambahkan event listener untuk periode juga
    document.getElementById('id_periode').addEventListener('change', function () {
      document.getElementById('id_unit').dispatchEvent(new Event('change'));
    });
  </script>

</body>

</html>