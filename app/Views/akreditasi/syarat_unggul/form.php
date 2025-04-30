<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              Formulir Syarat Unggul
            </h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="syarat-unggul" enctype="multipart/form-data">
        <div class="m-portlet__body">

        <!-- ID untuk form edit, jika ada -->
        <input type="hidden" name="id" value="<?= isset($editData) ? $editData['id'] : ''; ?>">

        <!-- ID Lembaga Akreditasi -->
        <div class="form-group m-form__group">
          <label for="id_lembaga">Lembaga Akreditasi</label>
          <select class="form-control m-input" id="id_lembaga" name="id_lembaga">
            <option value="">-- Pilih Lembaga --</option>
            <?php foreach ($lembagas as $lembaga): ?>
              <option value="<?= $lembaga['id']; ?>" 
                <?= isset($editData['id_lembaga']) && $editData['id_lembaga'] == $lembaga['id'] ? 'selected' : ''; ?>>
                <?= $lembaga['nama']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Nama Syarat -->
        <div class="form-group m-form__group">
          <label for="nama">Nama Syarat Unggul</label>
          <input type="text" class="form-control m-input" id="nama" name="nama" placeholder="Masukkan Nama" maxlength="100" 
            value="<?= isset($editData) ? $editData['nama'] : ''; ?>" required>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
          <button type="submit" class="btn btn-primary"><?= isset($editData) ? 'Perbarui' : 'Simpan' ?></button>
          <button type="button" class="btn btn-secondary" onclick="handleCancel()">Batal</button>
        </div>
      </div>
      </form>
      <!--end::Form-->
      </div>
  </div>

      <?php if (!isset($editData)): ?>
    <div class="col-md-12 mt-4">
      <div class="m-portlet m-portlet--tabs">
        <div class="m-portlet__head">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <h3 class="m-portlet__head-text">
                Data Syarat Unggul
              </h3>
            </div>
          </div>
        </div>

        <div class="m-portlet__body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nama Lembaga</th>
                <th>Nama Syarat Unggul</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dataSyarat as $syarat): ?>
                <tr>
                  <td>
                    <?php
                      $lembaga = null;
                      foreach ($lembagas as $l) {
                        if ($l['id'] == $syarat['id_lembaga']) {
                          $lembaga = $l['nama'];
                          break;
                        }
                      }
                      echo $lembaga ? $lembaga : 'Lembaga Tidak Ditemukan';
                    ?>
                  </td>
                  <td><?= $syarat['nama']; ?></td>
                  <td>
                  <button class="btn btn-sm btn-warning" 
                    onclick="showEditConfirmation('<?= $syarat['id'] ?>', '<?= esc($syarat['nama']) ?>')"> 
                    Edit
                  </button>
                    <!-- Tombol Delete -->
                    <button class="btn btn-sm btn-danger" 
                          onclick="showDeleteModal('<?= $syarat['id'] ?>', '<?= esc($syarat['nama']) ?>')">
                    Hapus
                  </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php endif; ?>
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
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editModalLabel">Konfirmasi Edit</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin mengedit data syarat unggul ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" onclick="confirmEdit()">Ya, Edit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

<script>
    function handleCancel() {
        <?php if (isset($editData)): ?>
            // If editing, redirect to the list or home page
            window.location.href = 'syarat-unggul'; // You can change this to redirect to a different page
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
      `Apakah Anda yakin ingin menghapus data <strong>${nama}</strong>?`;

    // Menampilkan modal
    $('#deleteModal').modal('show');
  }

  function showEditConfirmation(id, nama) {
    // Menyesuaikan pesan yang akan ditampilkan pada modal
    document.getElementById('editModalLabel').innerText = "Konfirmasi Edit";
    document.getElementById('editModal').querySelector('.modal-body').innerHTML = `Apakah Anda yakin ingin mengedit data syarat unggul: <strong>${nama}</strong>?`;
    
    // Menyimpan ID yang akan diedit di data-id
    document.getElementById('editModal').setAttribute('data-id', id);
    
    // Menampilkan modal
    $('#editModal').modal('show');
}

function confirmEdit() {
    var id = document.getElementById('editModal').getAttribute('data-id');
    window.location.href = 'syarat-unggul?id=' + id; // Arahkan ke form edit dengan ID yang sesuai
}
</script>
