<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Akreditasi</h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="<?= site_url('akreditasi/input') ?>" enctype="multipart/form-data">
        <div class="m-portlet__body">

        <!-- ID input, hidden field -->
        <input type="hidden" name="id" value="<?= isset($editData) ? $editData['id'] : ''; ?>">
          
          <!-- ID Unit -->
          <div class="form-group m-form__group">
            <label for="id_unit">Unit</label>
            <select class="form-control m-input js-example-basic-multiple" id="id_unit" name="id_unit" required>
              <option value="">-- Pilih Unit --</option>
              <?php foreach ($units as $unit): ?>
                <option value="<?= $unit['id']; ?>" 
                  <?= isset($dataAkreditasi['id_unit']) && $dataAkreditasi['id_unit'] == $unit['id'] ? 'selected' : ''; ?>>
                  <?= $unit['nama']; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- ID Lembaga Akreditasi -->
        <div class="form-group m-form__group">
          <label for="id_lembaga">Lembaga Akreditasi</label>
          <select class="form-control m-input js-example-basic-multiple" id="id_lembaga" name="id_lembaga" required>
            <option value="">-- Pilih Lembaga --</option>
            <?php foreach ($lembagas as $lembaga): ?>
              <option value="<?= $lembaga['id']; ?>" 
                <?= isset($dataAkreditasi['id_lembaga']) && $dataAkreditasi['id_lembaga'] == $lembaga['id'] ? 'selected' : ''; ?>>
                <?= $lembaga['nama']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

          <!-- Nilai Akreditasi -->
          <div class="form-group m-form__group">
            <label for="nilai_akreditasi">Nilai Akreditasi</label>
            <input type="number" class="form-control m-input" id="nilai_akreditasi" name="nilai_akreditasi" 
            value="<?= isset($dataAkreditasi['nilai']) ? $dataAkreditasi['nilai'] : ''; ?>" required>
          </div>

          <!-- Status -->
          <div class="form-group m-form__group">
          <label for="status">Status</label>
          <select class="form-control m-input" id="status" name="status" required>
          <option value="">-- Tentukan Status --</option>
              <?php
                $statusOptions = [
                  1 => 'Unggul', 2 => 'Baik Sekali', 3 => 'Baik', 4 => 'A', 
                  5 => 'B', 6 => 'C', 7 => 'Minimum', 8 => 'Tidak Ada'
                ];
              ?>
              <?php foreach ($statusOptions as $key => $value): ?>
                <option value="<?= $key; ?>" 
                  <?= isset($dataAkreditasi['status']) && $dataAkreditasi['status'] == $key ? 'selected' : ''; ?>>
                  <?= $value; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Is Active -->
        <div class="form-group m-form__group">
            <label>Is Active</label><br>
            <label class="radio-inline">
                <input type="radio" name="is_active" value="0" 
                <?= isset($dataAkreditasi['is_active']) && $dataAkreditasi['is_active'] == 'f' ? 'checked' : ''; ?> required>
                Tidak Aktif
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_active" value="1" 
                <?= isset($dataAkreditasi['is_active']) && $dataAkreditasi['is_active'] == 't' ? 'checked' : ''; ?> required>
                Aktif
            </label>
        </div>

          <!-- Tanggal Berlaku -->
          <div class="form-group m-form__group">
            <label for="tanggal_berlaku">Tanggal Berlaku</label>
            <input type="date" class="form-control m-input" id="tanggal_berlaku" name="tanggal_berlaku" value="<?= isset($dataAkreditasi['tanggal_berlaku']) ? $dataAkreditasi['tanggal_berlaku'] : ''; ?>" required>
          </div>

          <!-- Tanggal Habis -->
          <div class="form-group m-form__group">
            <label for="tanggal_habis">Tanggal Habis</label>
            <input type="date" class="form-control m-input" id="tanggal_habis" name="tanggal_habis" value="<?= isset($dataAkreditasi['tanggal_habis']) ? $dataAkreditasi['tanggal_habis'] : ''; ?>" required>
          </div>

          <!-- File Upload -->
        <div class="form-group m-form__group">
          <label for="file_upload">Unggah Dokumen</label>
          <input type="file" class="form-control m-input" id="file_upload" name="file_upload" accept=".pdf,.doc,.docx" 
            onchange="updateFileName()">
          <?php if (isset($uploadedFile)): ?>
            <div class="mt-2">
              <strong>File yang diupload: </strong> <?= $uploadedFile ?> 
              <br>
              <span>
                (Abaikan jika tidak ingin mengganti file)
              </span>
            </div>
          <?php endif; ?>
          <span class="m-form__help">
            File yang diperbolehkan: PDF, DOC, DOCX
          </span>
        </div>


        <!-- Submit Button -->
        <div class="m-portlet_foot m-portlet_foot--fit">
          <div class="m-form__actions">
            <a href="<?= base_url('public/akreditasi') ?>" class="btn btn-danger me-2">
              <i class="fa fa-arrow-left"></i> Batal
            </a>
            <button type="reset" class="btn btn-warning me-2">
              <i class="fa fa-paint-brush"></i> Reset
            </button>

            <button type="submit" value="add" class="btn btn-primary">
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
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title" id="updateModalLabel">Konfirmasi Perbarui Data</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin memperbarui dokumen ini?
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
  $(document).ready(function () {
      $('.js-example-basic-multiple').select2({
        placeholder: "-- Pilih --",
        allowClear: true
      });
    });

    function showEditModal(id) {
      document.getElementById('editId').value = id;
      $('#editModal').modal('show');
  }

  function confirmEdit() {
      var id = document.getElementById('editId').value;
      window.location.href = 'akreditasi?id=' + id;
  }

  function updateFileName() {
  var fileInput = document.getElementById("file_upload");
  var fileName = fileInput.files.length > 0 ? fileInput.files[0].name : "No file chosen";
  
  fileInput.nextElementSibling.innerHTML = fileName;
}
</script>