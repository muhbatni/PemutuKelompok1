<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">
              Form Akreditasi
            </h3>
          </div>
        </div>
      </div>
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="simpan_data.php">
        <div class="m-portlet__body">
          
          <!-- ID Unit -->
          <div class="form-group m-form__group">
            <label for="id_unit">Unit</label>
            <select class="form-control m-input" id="id_unit" name="id_unit">
              <option value="">-- Pilih Unit --</option>
              <?php foreach ($units as $unit): ?>
              <option value="<?= $unit['id']; ?>"><?= $unit['nama']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- ID Lembaga Akreditasi -->
          <div class="form-group m-form__group">
            <label for="id_lembaga">Lembaga Akreditasi</label>
            <select class="form-control m-input" id="id_lembaga" name="id_lembaga">
              <option value="">-- Pilih Lembaga --</option>
              <option value="1">BAN-PT</option>
              <option value="2">LAM-Infokom</option>
            </select>
          </div>

          <!-- Nilai Akreditasi -->
          <div class="form-group m-form__group">
            <label for="nilai_akreditasi">Nilai Akreditasi</label>
            <select class="form-control m-input" id="nilai_akreditasi" name="nilai_akreditasi">
              <option value="">-- Pilih Nilai --</option>
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
          </div>

          <!-- Status -->
          <div class="form-group m-form__group">
            <label for="status">Status</label>
            <select class="form-control m-input" id="status" name="status">
              <option value="">-- Pilih Status --</option>
              <option value="1">Unggul</option>
              <option value="2">Baik Sekali</option>
              <option value="3">Baik</option>
              <option value="4">A</option>
              <option value="5">B</option>
              <option value="6">C</option>
              <option value="7">Minimum</option>
              <option value="3">Tidak Ada</option>
            </select>
          </div>

          <!-- Tanggal Berlaku -->
          <div class="form-group m-form__group">
            <label for="tanggal_berlaku">Tanggal Berlaku</label>
            <input type="date" class="form-control m-input" id="tanggal_berlaku" name="tanggal_berlaku">
          </div>

          <!-- Tanggal Habis -->
          <div class="form-group m-form__group">
            <label for="tanggal_habis">Tanggal Habis</label>
            <input type="date" class="form-control m-input" id="tanggal_habis" name="tanggal_habis">
          </div>

          <!-- File Upload -->
          <div class="form-group m-form__group">
            <label for="file_upload">File Upload</label>
            <input type="file" class="form-control m-input" id="file_upload" name="file_upload">
          </div>
        </div>

        <!-- Submit Button -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-secondary">Batal</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>