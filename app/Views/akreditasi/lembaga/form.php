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

      <form action="<?= base_url('public/akreditasi/lembaga') ?>" method="post" class="m-form m-form--fit m-form--label-align-right" id="formLembaga">
        <input type="hidden" name="id" value="<?= $isEdit ? $editData['id'] : '' ?>">

        <div class="form-group m-form__group">
          <label for="nama">Nama Lembaga</label>
          <input type="text" name="nama" class="form-control m-input" id="nama"
                 placeholder="Masukkan nama lembaga" required value="<?= $isEdit ? esc($editData['nama']) : '' ?>">
        </div>

        <div class="form-group m-form__group">
          <label for="deskripsi">Deskripsi</label>
          <textarea name="deskripsi" class="form-control m-input" id="deskripsi"
                    rows="4"><?= $isEdit ? esc($editData['deskripsi']) : '' ?></textarea>
        </div>

        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <a href="<?= base_url('public/akreditasi/lembaga') ?>" class="btn btn-danger me-2">
              <i class="fa fa-arrow-left"></i> Batal
            </a>
            <button type="reset" class="btn btn-warning me-2">
              <i class="fa fa-paint-brush"></i> Reset
            </button>
            <?php if ($isEdit): ?>
              <button type="button" class="btn btn-primary" onclick="showUpdateModal()">
                <i class="fa fa-save"></i> Perbarui
              </button>
            <?php else: ?>
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Simpan
              </button>
            <?php endif; ?>
          </div>
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
        <button type="button" class="btn btn-warning" onclick="submitUpdate()">
          Ya, Perbarui
        </button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<script>
  function showUpdateModal() {
    const nama = document.getElementById('nama').value;
    if (!nama.trim()) {
      alert('Field Nama wajib diisi.');
      return;
    }
    $('#updateModal').modal('show');
  }

  function submitUpdate() {
    document.getElementById('formLembaga').submit();
  }
</script>
