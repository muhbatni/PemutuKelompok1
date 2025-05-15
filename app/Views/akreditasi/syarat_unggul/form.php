<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Syarat Unggul</h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right"
        action="<?= site_url('akreditasi/syarat-unggul/input') ?>" method="POST" enctype="multipart/form-data"
        id="syaratForm">

        <!-- ID untuk form edit, jika ada -->
        <input type="hidden" name="id" value="<?= isset($editData) ? $editData['id'] : ''; ?>">

        <!-- ID Lembaga Akreditasi -->
        <div class="form-group m-form__group">
          <label for="id_lembaga">Lembaga Akreditasi</label>
          <select class="form-control m-input" id="id_lembaga" name="id_lembaga" required>
            <option value="">-- Pilih Lembaga --</option>
            <?php foreach ($lembagas as $lembaga): ?>
              <option value="<?= $lembaga['id'] ?>" <?=
                  (old('id_lembaga') ?? ($editData['id_lembaga'] ?? '')) == $lembaga['id'] ? 'selected' : '' ?>>
                <?= esc($lembaga['nama']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Nama Syarat -->
        <div class="form-group m-form__group">
          <label for="nama">Nama Syarat Unggul</label>
          <input type="text" class="form-control m-input" id="nama" name="nama" placeholder="Masukkan Nama"
            maxlength="100" value="<?= isset($editData) ? $editData['nama'] : ''; ?>" required>
        </div>

        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <a href="<?= base_url('public/akreditasi/syarat-unggul') ?>" class="btn btn-danger me-2">
              <i class="fa fa-arrow-left"></i> Batal
            </a>
            <button type="reset" class="btn btn-warning me-2">
              <i class="fa fa-paint-brush"></i> Reset
            </button>

            <button type="submit" class="btn btn-primary">
              <i class="fa fa-save"></i> <?= isset($editData) ? 'Perbarui' : 'Simpan' ?>
            </button>
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

<!-- Modal Update -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
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
  function showUpdateModal() {
    // Validasi manual sebelum tampilkan modal update
    const nama = document.getElementById('nama').value;

    if (!nama) {
      alert('Nama wajib diisi.');
      return;
    }

    $('#updateModal').modal('show');
  }

  function submitUpdate() {
    document.getElementById('syaratForm').submit();
  }
</script>