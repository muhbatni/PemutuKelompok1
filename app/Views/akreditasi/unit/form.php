<?php $isEdit = isset($edit); ?>

<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              Formulir Unit
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="<?= $isEdit ? 'unit?edit=' . esc($edit['id']) : 'unit' ?>">

        <div class="m-portlet__body">
          <?php if ($isEdit): ?>
              <input type="hidden" name="id" value="<?= esc($edit['id']) ?>">
          <?php endif ?>  
        </div>

          <!-- Nama Unit -->
          <div class="form-group m-form__group row">
          <label for="nama" class="col-2 col-form-label">Nama Unit</label>
          <div class="col-10">
            <input class="form-control m-input" type="text" id="nama" name="nama" placeholder="Masukkan Nama Unit"
            value="<?= $isEdit ? esc($edit['nama']) : '' ?>" required>
          </div>
        </div>

          <!-- Parent Unit -->
          <div class="form-group m-form__group row">
          <label for="parent" class="col-2 col-form-label">Parent</label>
          <div class="col-10">
            <select class="form-control m-input" id="parent" name="parent" 
            value="<?= $isEdit ? esc($edit['parent']) : '' ?>" required>
              <option value="">-- Pilih Kode Fakultas --</option>
              <option value="1">01 - Fakultas Sains dan Teknologi</option>
              <option value="2">02 - Fakultas Adab dan Humaniora</option>
              <option value="3">03 - Fakultas Syariah dan Hukum</option>
              <option value="4">04 - Fakultas Tarbiyah dan Keguruan</option>
              <option value="5">05 - Fakultas Ilmu Sosial dan Ilmu Politik</option>
            </select>
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
            <h3 class="m-portlet__head-text">Daftar Unit</h3>
          </div>
        </div>
      </div>
      <div class="m-portlet__body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Parent</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($unit)) : ?>
              <?php $no = 1; foreach ($unit as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= esc($row['nama']) ?></td>
                  <td><?= esc($row['parent']) ?></td>
                  <td>
                    <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <button class="btn btn-sm btn-danger" onclick="showDeleteModal('<?= $row['id'] ?>', '<?= esc($row['parent']) ?>')">Hapus</button>
                  </td>
                </tr>
              <?php endforeach ?>
            <?php else : ?>
              <tr>
                <td colspan="4" class="text-center">Belum ada data unit.</td>
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