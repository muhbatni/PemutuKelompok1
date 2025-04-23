<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Instrumen Pemutu </h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" action="instrumen-pemutu" method="post"
        enctype="multipart/form-data">
        <div class="m-portlet__body">

          <!-- ID Field (Auto-generated) -->
          <input type="hidden" name="delete" id="deleteId">

          <!-- id_lembaga Field -->
          <div class="form-group m-form__group">
            <label for="id_lembaga">Lembaga Akreditasi</label>
            <select class="form-control m-input" id="id_lembaga" name="id_lembaga">
              <option value="">-- Pilih Lembaga --</option>
              <?php foreach ($lembagas as $lembaga): ?>
                <option value="<?= $lembaga['id']; ?>"><?= $lembaga['nama']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Jenjang Field -->
          <div class="form-group m-form__group">
            <label for="jenjang">Jenjang</label>
            <select name="jenjang" id="jenjang" class="form-control m-input" required>
              <option value="">-- Pilih Jenjang --</option>
              <option value="1" <?= old('jenjang') == 1 ? 'selected' : '' ?>>S3</option>
              <option value="2" <?= old('jenjang') == 2 ? 'selected' : '' ?>>S2</option>
              <option value="3" <?= old('jenjang') == 3 ? 'selected' : '' ?>>S1</option>
              <option value="4" <?= old('jenjang') == 4 ? 'selected' : '' ?>>D4</option>
              <option value="5" <?= old('jenjang') == 5 ? 'selected' : '' ?>>D3</option>
              <option value="6" <?= old('jenjang') == 6 ? 'selected' : '' ?>>D2</option>
              <option value="7" <?= old('jenjang') == 7 ? 'selected' : '' ?>>D1</option>
            </select>
          </div>


          <!-- Indikator Field -->
          <div class="form-group m-form__group">
            <label for="indikator">Indikator</label>
            <input type="text" name="indikator" id="indikator" maxlength="255" required placeholder="Enter Indikator"
              class="form-control m-input">
          </div>

          <!-- Kondisi Field -->
          <div class="form-group m-form__group">
            <label for="kondisi">Kondisi</label>
            <select name="kondisi" id="kondisi" class="form-control m-input" required>
              <option value="">-- Pilih Kondisi --</option>
              <option value="<" <?= old('kondisi') == '<' ? 'selected' : '' ?>>Kurang dari (&lt;)</option>
              <option value="=" <?= old('kondisi') == '=' ? 'selected' : '' ?>>Sama dengan (=)</option>
              <option value=">" <?= old('kondisi') == '>' ? 'selected' : '' ?>>Lebih dari (&gt;)</option>
            </select>
          </div>

          <!-- Batas Field -->
          <div class="form-group m-form__group">
            <label for="batas">Batas</label>
            <input type="number" name="batas" id="batas" placeholder="Enter Batas" class="form-control m-input"
              required>
          </div>

        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-secondary">Batal</button>
          </div>
        </div>

      </form>
      <!--end::Form-->

    </div>
  </div>
</div>


<!-- TABEL DATA -->
<div class="row mt-5">
  <div class="col-md-12">
    <div class="m-portlet">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Daftar Instrumen Pemutu</h3>
          </div>
        </div>
      </div>
      <div class="m-portlet__body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Lembaga</th>
              <th>Jenjang</th>
              <th>Indikator</th>
              <th>Kondisi</th>
              <th>Batas</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($instrumen_pemutu)): ?>
              <?php $no = 1;
              foreach ($instrumen_pemutu as $row): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= esc($row['nama_lembaga']) ?></td>
                  <td><?= esc($row['jenjang']) ?></td>
                  <td><?= esc($row['indikator']) ?></td>
                  <td><?= esc($row['kondisi']) ?></td>
                  <td><?= esc($row['batas']) ?></td>
                  <td>
                    <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <button type="button" class="btn btn-sm btn-danger"
                      onclick="showDeleteModal('<?= $row['id'] ?>')">Hapus</button>
                  </td>
                </tr>
              <?php endforeach ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center">Belum ada data instrumen.</td>
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
          <h5 class="modal-title">Konfirmasi Hapus</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="delete" id="deleteId">
          <p id="deleteMessage">Apakah Anda yakin ingin menghapus data ini?</p>
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
  function showDeleteModal(id) {
    document.getElementById('deleteId').value = id;
    $('#deleteModal').modal('show');
  }
</script>
