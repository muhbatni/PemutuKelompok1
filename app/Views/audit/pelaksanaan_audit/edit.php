<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Pelaksanaan Audit
          </h3>
        </div>
      </div>
    </div>

    <form id="audit-form" class="mt-4" method="POST" action="<?= base_url('public/audit/pelaksanaan-audit/simpan') ?>">
      <input type="hidden" name="id_standar_audit" value="<?= esc($standar_audit_id ?? $id_standar_audit ?? ''); ?>">
      <div class="m-portlet__body">
        <!-- Begin: Filter Section -->
        <div class="row mb-4">
          <div class="col-md-5">
            <div class="form-group">
              <label for="audit_select">Pilih Auditor:</label>
              <select class="form-control m-select2" id="audit_select" name="id_auditor" <?= !empty($isExistingData) ? 'disabled' : '' ?> <?= empty($isExistingData) ? 'required' : '' ?>>
                <option value="">-- Pilih Auditor --</option>
                <?php foreach ($auditor_list as $auditor): ?>
                  <option value="<?= $auditor->id_auditor ?>" <?= (isset($firstStandar['id_auditor']) && $firstStandar['id_auditor'] == $auditor->id_auditor) ? 'selected' : '' ?>>
                    <?= $auditor->nama_auditor ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <?php if (!empty($isExistingData)): ?>
                <!-- Hidden input hanya jika select disabled, pastikan tidak duplikat -->
                <input type="hidden" name="id_auditor" value="<?= esc($firstStandar['id_auditor'] ?? '') ?>">
              <?php endif; ?>
            </div>
          </div>

          <div class="col-md-7">
            <div class="form-group">
              <label for="unit_select">Pilih Unit:</label>
              <select class="form-control m-select2" id="unit_select" name="id_unit" <?= !empty($isExistingData) ? 'disabled' : '' ?> <?= empty($isExistingData) ? 'required' : '' ?>>
                <option value="">-- Pilih Unit --</option>
                <?php foreach ($unit_list as $unit): ?>
                  <option value="<?= $unit->id_unit ?>" <?= (isset($firstStandar['id_unit']) && $firstStandar['id_unit'] == $unit->id_unit) ? 'selected' : '' ?>>
                    <?= $unit->nama_unit ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <?php if (!empty($isExistingData)): ?>
                <!-- Hidden input hanya jika select disabled, pastikan tidak duplikat -->
                <input type="hidden" name="id_unit" value="<?= esc($firstStandar['id_unit'] ?? '') ?>">
              <?php endif; ?>
            </div>
          </div>

        </div>
        <!-- End: Filter Section -->

        <!-- Left Panel: Standards List -->
        <div class="row">
          <div class="col-md-5">
            <!-- Standar Header -->
            <div class="card mb-3">
              <div class="card-header bg-primary text-white">
                <h5 class="m-0">Daftar Standar</h5>
              </div>
            </div>

            <div id="list-standar">
              <?php foreach ($standar as $item): ?>
                <!-- Standar Item -->
                <div class="card mb-2">
                  <div class="card-header p-2">
                    <a href="#" class="list-group-item list-group-item-action border-0 p-2"
                      data-standar-id="<?= $item->id_standar ?>">
                      <i class="fa fa-folder-open mr-2"></i> <?= esc($item->nama) ?>
                    </a>
                  </div>

                  <!-- Pernyataan Items (hidden by default) -->
                  <div class="list-pernyataan card-body p-0" data-wrapper-id="<?= $item->id_standar ?>"
                    style="display: none; border-top: 1px solid #ebedf2;">
                    <!-- Pernyataan akan dimuat di sini oleh AJAX -->
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Right Panel: Statement & Form -->
          <div class="col-md-7">
            <div class="card">
              <div class="card-header bg-info text-white">
                <h5 class="m-0">Detail Pernyataan</h5>
              </div>
              <div class="card-body" id="indicator-content">
                <div class="text-center text-muted p-5">
                  <i class="fa fa-info-circle fa-3x mb-3"></i>
                  <p>Silakan pilih pernyataan dari daftar di sebelah kiri untuk melihat detailnya</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-md-12 text-right">
            <button type="button" class="btn btn-success" onclick="$('#audit-form').submit();">Simpan</button>
            <button type="button" class="btn btn-outline-secondary ml-2"
              onclick="window.location.href='<?= base_url('public/audit/pelaksanaan-audit'); ?>'">
              Kembali
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>



<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Initialize select2 for better dropdown experience
    $('.m-select2').select2();

    // Handle audit and unit selection
    $('#audit_select, #unit_select').change(function () {
      var auditId = $('#audit_select').val();
      var unitId = $('#unit_select').val();
    });

    // Ketika klik standar, ambil pernyataan
    $('#list-standar').on('click', '.list-group-item', function (e) {
      e.preventDefault();

      console.log("Elemen yang diklik:", this);

      var standarId = $(this).attr('data-standar-id');
      // Tambahkan kelas aktif dan hapus dari yang lain
      $('#list-standar .list-group-item').removeClass('active bg-light');
      $(this).addClass('active bg-light');

      console.log("Nilai standarId:", standarId);

      // Periksa apakah standarId tersedia
      if (!standarId) {
        console.error("Error: standarId tidak ditemukan pada elemen yang diklik");
        return;
      }

      var pernyataanWrapper = $('.list-pernyataan[data-wrapper-id="' + standarId + '"]');

      // Toggle tampil / sembunyikan
      $('.list-pernyataan').not(pernyataanWrapper).slideUp();
      pernyataanWrapper.slideToggle();

      // Cegah ajax dobel
      if (pernyataanWrapper.children().length > 0) return;

      // Tampilkan loading
      pernyataanWrapper.html('<div class="text-center p-3"><i class="fa fa-spinner fa-spin"></i> Memuat data...</div>');

      // Ambil pernyataan
      $.ajax({
        url: '<?= base_url('public/audit/pelaksanaan-audit/getPernyataanByStandar/') ?>' + standarId,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          console.log("Data yang diterima:", data);
          if (data && data.length > 0) {
            var html = '';
            data.forEach(function (item) {
              html += `
                <a href="#" class="list-group-item list-group-item-action pernyataan-item py-2 px-3 border-0 border-bottom" data-id="${item.id}">
                  <div class="d-flex align-items-center">
                    <i class="fa fa-file-text-o mr-2 text-muted"></i>
                    <span>${item.pernyataan}</span>
                  </div>
                </a>
              `;
            });
            pernyataanWrapper.html(html);
          } else {
            pernyataanWrapper.html('<div class="text-center p-3 text-muted"><small>Tidak ada pernyataan</small></div>');
          }
        },
        error: function (xhr, status, error) {
          console.error('Error AJAX:', xhr.responseText);
          pernyataanWrapper.html('<div class="text-center p-3 text-danger"><small>Gagal ambil data</small></div>');
        }
      });
    });

    // Ketika klik pernyataan, ambil detail-nya
    $('body').on('click', '.pernyataan-item', function (e) {
      e.preventDefault();

      console.log("Pernyataan yang diklik:", this);

      // Tambahkan kelas aktif dan hapus dari yang lain
      $('.pernyataan-item').removeClass('active bg-light');
      $(this).addClass('active bg-light');

      var id = $(this).attr('data-id');
      console.log("ID pernyataan:", id);

      // Periksa apakah id tersedia
      if (!id) {
        console.error("Error: id pernyataan tidak ditemukan");
        return;
      }

      // Tampilkan loading
      $('#indicator-content').html('<div class="text-center p-5"><i class="fa fa-spinner fa-spin"></i> Memuat detail...</div>');

      $.ajax({
        url: '<?= base_url('public/audit/pelaksanaan-audit/getDetailPernyataan/') ?>' + id,
        method: 'GET',
        dataType: 'json',
        success: function (item) {
          console.log("Detail pernyataan:", item);
          var html = `
            <div class="card border-0">
              <div class="card-body p-0">
                <div class="mb-4">
                  <h5 class="card-title border-bottom pb-2">Pernyataan</h5>
                  <p class="card-text">${item.pernyataan || '-'}</p>
                </div>
                
                <div class="mb-4">
                  <h5 class="card-title border-bottom pb-2">Indikator</h5>
                  <p class="card-text">${item.indikator || '-'}</p>
                </div>
                
                <div class="mb-4">
                  <h5 class="card-title border-bottom pb-2">Kondisi</h5>
                  <p class="card-text">${item.kondisi || '-'}</p>
                </div>
                
                <div class="mb-4">
                  <h5 class="card-title border-bottom pb-2">Batas</h5>
                  <p class="card-text">${item.batas || '-'}</p>
                </div>
                
                  <input type="hidden" name="id_pernyataan" value="${id}">
                  <input type="hidden" name="id_unit" value="${$('#unit_select').val()}">
                  <input type="hidden" name="id_auditor" value="${$('#audit_select').val()}">
                  <input type="hidden" name="id_standar_audit" value="<?= $standar_audit_id ?>">
                  
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="capaian">Capaian:</label>
                      <input type="number" class="form-control" id="capaian" name="capaian" placeholder="Nilai capaian">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="is_temuan">Temuan:</label>
                      <div class="custom-control custom-switch mt-2">
                        <input type="checkbox" class="custom-control-input" id="is_temuan" name="is_temuan">
                        <label class="custom-control-label" for="is_temuan">Ya / Tidak</label>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="kondisi">Kondisi:</label>
                    <textarea class="form-control" id="kondisi" name="kondisi" rows="2" placeholder="Deskripsikan kondisi..."></textarea>
                  </div>
                  
                  <div class="form-group">
                    <label for="akar">Akar Masalah:</label>
                    <textarea class="form-control" id="akar" name="akar" rows="2" placeholder="Deskripsikan akar masalah..."></textarea>
                  </div>
                  
                  <div class="form-group">
                    <label for="akibat">Akibat:</label>
                    <textarea class="form-control" id="akibat" name="akibat" rows="2" placeholder="Deskripsikan akibat..."></textarea>
                  </div>
                  
                  <div class="form-group">
                    <label for="rekom">Rekomendasi:</label>
                    <textarea class="form-control" id="rekom" name="rekom" rows="2" placeholder="Berikan rekomendasi..."></textarea>
                  </div>
                  
                  <div class="form-group">
                    <label for="tanggapan">Tanggapan:</label>
                    <textarea class="form-control" id="tanggapan" name="tanggapan" rows="2" placeholder="Berikan tanggapan..."></textarea>
                  </div>
                  
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="rencana_perbaikan">Rencana Perbaikan:</label>
                      <textarea class="form-control" id="rencana_perbaikan" name="rencana_perbaikan" rows="2" placeholder="Rencana perbaikan..."></textarea>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="tanggal_perbaikan">Tanggal Perbaikan:</label>
                      <input type="date" class="form-control" id="tanggal_perbaikan" name="tanggal_perbaikan">
                    </div>
                  </div>
                  
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="rencana_pencegahan">Rencana Pencegahan:</label>
                      <textarea class="form-control" id="rencana_pencegahan" name="rencana_pencegahan" rows="2" placeholder="Rencana pencegahan..."></textarea>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="tanggal_pencegahan">Tanggal Pencegahan:</label>
                      <input type="date" class="form-control" id="tanggal_pencegahan" name="tanggal_pencegahan">
                    </div>
                  </div>

              </div>
            </div>
          `;
          $('#indicator-content').html(html);
        },
        error: function (xhr, status, error) {
          console.error('Error AJAX:', xhr.responseText);
          $('#indicator-content').html('<div class="alert alert-danger">Gagal mengambil detail.</div>');
        }
      });
    });
  });
  document.querySelector('.btn-success').addEventListener('click', function () {
    if ($('#audit-form')[0].checkValidity()) {
      $('#audit-form').submit();
    } else {
      $('#audit-form')[0].reportValidity();
    }
  });

  $(document).ready(function() {
    <?php if (!empty($isExistingData)): ?>
      $('select[name="id_auditor"]').prop('disabled', true);
      $('select[name="id_unit"]').prop('disabled', true);
    <?php endif; ?>
  });
</script>

<style>
  /* Styling untuk standar */
  #list-standar .list-group-item {
    transition: all 0.2s;
    border-radius: 0;
  }

  #list-standar .list-group-item:hover {
    background-color: #f8f9fa;
  }

  #list-standar .list-group-item.active {
    background-color: #e9f0fd;
    color: #3f51b5;
    border-color: #d1dff7;
  }

  /* Styling untuk pernyataan */
  .pernyataan-item {
    padding-left: 2rem !important;
    font-size: 0.9rem;
    transition: all 0.2s;
  }

  .pernyataan-item:hover {
    background-color: #f8f9fa;
  }

  .pernyataan-item.active {
    background-color: #e8f4f8;
    color: #0a58ca;
  }

  /* Card styling */
  .card-header {
    font-weight: 500;
  }

  /* Fix untuk font awesome jika perlu */
  .fa {
    width: 16px;
    text-align: center;
  }
</style>