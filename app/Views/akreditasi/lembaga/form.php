<?php $isEdit = isset($editData); ?>

<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Lembaga Akreditasi</h3>
          </div>
        </div>
      </div>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success m-3"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>

      <form action="lembaga" method="post" class="m-form m-form--fit m-form--label-align-right" id="formLembaga">
        <input type="hidden" name="id" value="<?= $isEdit ? $editData['id'] : '' ?>">

          <div class="form-group m-form__group">
            <label for="nama">Nama Lembaga</label>
            <input type="text" name="nama" class="form-control m-input" id="nama"
                   placeholder="Masukkan nama lembaga" required value="<?= $isEdit ? esc($editData['nama']) : '' ?>">
          </div>

          <div class="form-group m-form__group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control m-input" id="deskripsi"
                      rows="4" ><?= $isEdit ? esc($editData['deskripsi']) : '' ?></textarea>
          </div>
        </div>

        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <?php if ($isEdit): ?>
              <button type="button" class="btn btn-primary" onclick="showUpdateModal()">Perbarui</button>
            <?php else: ?>
              <button type="submit" class="btn btn-primary">Simpan</button>
            <?php endif; ?>
            <a href="<?= base_url('public/akreditasi/lembaga') ?>" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Tabel Data -->
<div class="row mt-5">
  <div class="col-md-12">
    <div class="m-portlet">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Daftar Lembaga Akreditasi</h3>
          </div>
        </div>
      </div>
      <div class="m-portlet__body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Lembaga</th>
              <th>Deskripsi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($lembaga)) : ?>
              <?php $no = 1; foreach ($lembaga as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= esc($row['nama']) ?></td>
                  <td><?= esc($row['deskripsi']) ?></td>
                  <td>
                    <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <button class="btn btn-sm btn-danger" onclick="showDeleteModal('<?= $row['id'] ?>', '<?= esc($row['nama']) ?>')">Hapus</button>
                  </td>
                </tr>
              <?php endforeach ?>
            <?php else : ?>
              <tr>
                <td colspan="4" class="text-center">Belum ada data.</td>
              </tr>
            <?php endif ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form method="get">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Konfirmasi Hapus</h5>
          <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
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

<!-- Modal Konfirmasi Perbarui -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">Konfirmasi Perbarui Data</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin memperbarui data lembaga ini?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" onclick="submitUpdate()">Ya, Perbarui</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script>
  function showDeleteModal(id, nama) {
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteMessage').innerHTML =
      `Yakin ingin menghapus lembaga <strong>${nama}</strong>?`;
    $('#deleteModal').modal('show');
  }

  function showUpdateModal() {
    $('#updateModal').modal('show');
  }

  function submitUpdate() {
    document.getElementById('formLembaga').submit();
  }
</script>