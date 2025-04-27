<?php $isEdit = isset($edit); ?>

<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Periode</h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="<?= $isEdit ? 'periode?edit=' . esc($edit['id']) : 'periode' ?>">

        <div class="form-group m-form__group row">
          <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= esc($edit['id']) ?>">
          <?php endif ?>  
        </div>

          <!-- Tahun -->
          <div class="form-group m-form__group row">
            <label for="tahun" class="col-2 col-form-label">Tahun</label>
            <div class="col-10">
              <input class="form-control m-input" type="number" id="tahun" name="tahun" placeholder="Masukkan Tahun" 
              value="<?= $isEdit ? esc($edit['tahun']) : '' ?>" required>
            </div>
          </div>

          <!-- Tahun Ajaran -->
          <div class="form-group m-form__group row">
            <label for="ts" class="col-2 col-form-label">Tahun Ajaran</label>
            <div class="col-10">
              <input class="form-control m-input" type="text" id="ts" name="ts" placeholder="Masukkan Tahun Ajaran" 
              value="<?= $isEdit ? esc($edit['ts']) : '' ?>" required>
            </div>
          </div>

        <!-- Button -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <?php if ($isEdit): ?>
              <button type="button" class="btn btn-primary" onclick="showUpdateModal()">Perbarui</button>
            <?php else: ?>
              <button type="submit" class="btn btn-primary">Simpan</button>
            <?php endif; ?>
            <a href="<?= base_url('public/akreditasi/periode') ?>" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </form>
      <!--end::Form-->
    </div>
  </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success mt-3">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<!-- TABEL DATA -->
<div class="row mt-5">
  <div class="col-md-12">
    <div class="m-portlet">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Daftar Periode</h3>
          </div>
        </div>
      </div>
      <div class="m-portlet__body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Tahun</th>
              <th>Tahun Ajaran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($periode)) : ?>
              <?php $no = 1; foreach ($periode as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= esc($row['tahun']) ?></td>
                  <td><?= esc($row['ts']) ?></td>
                  <td>
                    <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <button class="btn btn-sm btn-danger" onclick="showDeleteModal('<?= $row['id'] ?>', '<?= esc($row['ts']) ?>')">Hapus</button>
                  </td>
                </tr>
              <?php endforeach ?>
            <?php else : ?>
              <tr>
                <td colspan="4" class="text-center">Belum ada data periode.</td>
              </tr>
            <?php endif ?>
          </tbody>
        </table>
      </div>
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

<!-- Modal Update -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="" class="m-form">
      <input type="hidden" name="id" id="updateId">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="updateModalLabel">Konfirmasi Perbarui Data</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Apakah Anda yakin ingin memperbarui data ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" onclick="submitUpdate()">Ya, Perbarui</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<!-- Script -->
<script>
  function showDeleteModal(id, nama) {
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteMessage').innerHTML =
      `Apakah Anda yakin ingin menghapus data <strong>${nama}</strong>?`;
    $('#deleteModal').modal('show');
  }

  function showUpdateModal() {
    $('#updateModal').modal('show');
  }

  function submitUpdate() {
    document.querySelector('form.m-form').submit();
  }
</script>