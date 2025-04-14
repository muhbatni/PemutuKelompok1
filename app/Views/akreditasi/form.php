<form class="m-form m-form--fit m-form--label-align-right" method="POST" action="simpan_data.php">
  <div class="m-portlet__body">

    <!-- ID Unit -->
    <div class="form-group m-form__group">
      <label for="id_unit">Unit</label>
      <select class="form-control m-input" id="id_unit" name="id_unit">
        <option value="">-- Pilih Unit --</option>
        <!-- Data unit bisa di-loop dari PHP -->
        <option value="1">Teknik Informatika</option>
        <option value="2">Sistem Informasi</option>
      </select>
    </div>

    <!-- ID Lembaga Akreditasi -->
    <div class="form-group m-form__group">
      <label for="id_lembaga">Lembaga Akreditasi</label>
      <select class="form-control m-input" id="id_lembaga" name="id_lembaga">
        <option value="">-- Pilih Lembaga --</option>
        <!-- Data lembaga dari tabel m_lembaga_akreditasi -->
        <option value="1">BAN-PT</option>
        <option value="2">LAM-Infokom</option>
      </select>
    </div>

    <!-- Status -->
    <div class="form-group m-form__group">
      <label for="status">Status</label>
      <select class="form-control m-input" id="status" name="status">
        <option value="">-- Pilih Status --</option>
        <option value="1">Aktif</option>
        <option value="0">Tidak Aktif</option>
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

  </div>

  <!-- Submit Button -->
  <div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
      <button type="submit" class="btn btn-primary">Simpan</button>
      <button type="reset" class="btn btn-secondary">Batal</button>
    </div>
  </div>
</form>