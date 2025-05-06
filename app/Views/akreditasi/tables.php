<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Daftar Akreditasi
          </h3>
        </div>
      </div>
    </div>

    <div class="m-portlet__body">
      <!--begin: Search Form -->
      <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
        <div class="row align-items-center">
          <div class="col-xl-4 order-1 order-xl-1 m--align-left">
            <a href="/pemutu/public/akreditasi/input" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
              <span>
                <i class="flaticon-add"></i>
                <span>Input Akreditasi</span>
              </span>
            </a>
            <div class="m-separator m-separator--dashed d-xl-none"></div>
          </div>
          <div class="col-xl-8 order-2 order-xl-2">
            <div class="form-group m-form__group row align-items-center">
              <div class="col-md-4 ml-auto">
                <div class="m-input-icon m-input-icon--left">
                  <input type="text" class="form-control m-input m-input--solid" placeholder="Search..." id="generalSearch">
                  <span class="m-input-icon__icon m-input-icon__icon--left">
                    <span><i class="la la-search"></i></span>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--end: Search Form -->

      <!--begin: Datatable -->
      <table class="table table-bordered table-striped" id="html_table" width="100%">
      <thead>
              <tr>
                <th>Nama Unit</th>
                <th>Nama Lembaga</th>
                <th>Status</th>
                <th>Tanggal Berlaku</th>
                <th>Tanggal Habis</th>
                <th>Nilai</th>
                <th>Is Active</th>
                <th>File</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dataAkreditasi as $akreditasi): ?>
                <tr>
                  <td><?php
                  $namaUnit = 'Unit Tidak Ditemukan';
                  if (isset($akreditasi['id_unit'])) {
                      foreach ($units as $unit) {
                          if (isset($unit['id']) && $unit['id'] == $akreditasi['id_unit']) {
                              $namaUnit = $unit['nama'];
                              break;
                          }
                      }
                  }
                  echo $namaUnit;
                  ?></td>
                  <td><?php
                  $namaLembaga = 'Lembaga Tidak Ditemukan';
                  if (isset($akreditasi['id_lembaga'])) {
                      foreach ($lembagas as $lembaga) {
                          if (isset($lembaga['id']) && $lembaga['id'] == $akreditasi['id_lembaga']) {
                              $namaLembaga = $lembaga['nama'];
                              break;
                          }
                      }
                  }
                  echo $namaLembaga;
                  ?></td>
                  <td><?php
                    $status = '';
                    if (isset($akreditasi['status'])) {
                      switch ($akreditasi['status']) {
                          case 1: $status = 'Unggul'; break;
                          case 2: $status = 'Baik Sekali'; break;
                          case 3: $status = 'Baik'; break;
                          case 4: $status = 'A'; break;
                          case 5: $status = 'B'; break;
                          case 6: $status = 'C'; break;
                          case 7: $status = 'Minimum'; break;
                          case 8: $status = 'Tidak Ada'; break;
                          default: $status = 'Status Tidak Dikenal'; break;
                      }
                  } else {
                      $status = 'Status Tidak Ditemukan';
                  }
                  echo $status;
                  ?></td>
                  <td>
                    <?= isset($akreditasi['tanggal_berlaku']) ? $akreditasi['tanggal_berlaku'] : 'Tanggal Tidak Ditemukan'; ?>
                  </td>
                  <td>
                    <?= isset($akreditasi['tanggal_habis']) ? $akreditasi['tanggal_habis'] : 'Tanggal Tidak Ditemukan'; ?>
                  </td>
                  <td>
                    <?php
                      echo isset($akreditasi['nilai']) ? htmlspecialchars($akreditasi['nilai']) : 'Tidak Ada'; 
                    ?>
                  </td>
                  <td>
                  <?=
                    isset($akreditasi['is_active']) ? ($akreditasi['is_active'] === 't' ? 'Aktif' : 'Tidak Aktif') : 'Tidak Ada';
                  ?>
                  </td>
                  <td>
                    <?php if (isset($akreditasi['file']) && $akreditasi['file']): ?>
                      <a href="<?= base_url('public/akreditasi/download/' . esc($akreditasi['file'])) ?>" target="_blank" class="btn btn-sm btn-primary">
                      <i class="fa fa-download"></i> Download</a>
                    <?php else: ?>
                      Tidak ada file
                    <?php endif; ?>
                  </td>
                  <td>
                    <!-- Tombol Edit -->
                    <?php if (isset($akreditasi['id'])): ?>
                      <a href="<?= base_url('public/akreditasi/input?id=' . $akreditasi['id']); ?>" class="btn btn-sm btn-warning">
                        Edit
                      </a>
                    <?php endif; ?>
                    <!-- Tombol Hapus -->
                  <button class="btn btn-sm btn-danger" 
                          onclick="showDeleteModal('<?= $akreditasi['id'] ?>', '<?= esc($akreditasi['id_unit']) ?>')">
                    Hapus
                  </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
      </table>
      <!--end: Datatable -->
    </div>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form method="get">
            <div class="modal-header bg-danger text-white">
              <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="delete" id="deleteId">
              <p id="deleteMessage"></p>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger">Ya, Hapus</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>

<script>
  function handleCancel() {
        <?php if (isset($editData)): ?>
            // If editing, redirect to the list or home page
            window.location.href = 'akreditasi'; // You can change this to redirect to a different page
        <?php else: ?>
            // If adding a new record, reset the form
            document.querySelector("form").reset();
        <?php endif; ?>
    }

    function showDeleteModal(id, nama) {
    // Mengatur ID data yang akan dihapus
    document.getElementById('deleteId').value = id;
    
    // Menampilkan pesan konfirmasi penghapusan dengan nama data
    document.getElementById('deleteMessage').innerHTML = 
      Apakah Anda yakin ingin menghapus data <strong>${nama}</strong>?;

    // Menampilkan modal
    $('#deleteModal').modal('show');
  }
</script>

<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js" type="text/javascript"></script>