<?php $isEdit = isset($edit); ?>

<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Isian Pemutu</h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="post" action="">
        <?php if ($isEdit): ?>
          <input type="hidden" name="id" value="<?= esc($edit['id']) ?>">
        <?php endif ?>

        <!-- Pilih Unit Pemutu -->
        <div class="form-group m-form__group">
          <label for="id_unitpemutu">Pilih Unit Pemutu</label>
          <select class="form-control m-input" id="id_unitpemutu" name="id_unitpemutu" required>
            <option value="">-- Pilih --</option>
            <?php foreach ($unitpemutus as $unit): ?>
              <option value="<?= $unit['id'] ?>" <?= $isEdit && $edit['id_unitpemutu'] == $unit['id'] ? 'selected' : '' ?>>
                <?= $unit['nama'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Pilih Instrumen Pemutu -->
<div class="form-group m-form__group">
  <label for="id_instrumen">Pilih Instrumen</label>
  <select class="form-control m-input" id="id_instrumen" name="id_instrumen" required>
    <option value="">-- Pilih --</option>
    <?php foreach ($instrumen_list as $index => $instrumen): ?>
      <option value="<?= $instrumen['id'] ?>">
        <?= $index + 1 ?> <!-- Menampilkan penomoran urut -->
      </option>
    <?php endforeach ?>
  </select>
</div>


        <!-- form input untuk isi dari instrumen pemutu -->
        <div class="form-group m-form__group">
          <label for="lembaga">Isi dari Instrumen Pemutu</label>

          <input type="text" class="form-control m-input mb-2" id="lembaga" name="lembaga" placeholder="Lembaga"
            readonly>

          <input type="text" class="form-control m-input mb-2" id="jenjang_instrumen" name="jenjang_instrumen"
            placeholder="Jenjang" readonly>

          <input type="text" class="form-control m-input mb-2" id="indikator" name="indikator" placeholder="Indikator"
            readonly>

          <input type="text" class="form-control m-input mb-2" id="kondisi" name="kondisi" placeholder="Kondisi"
            readonly>

          <input type="text" class="form-control m-input mb-2" id="batas" name="batas" placeholder="Batas" readonly>
        </div>
        
        <div class="form-group m-form__group">
          <label for="isian">Isian</label>
          <select class="form-control m-input" id="isian" name="isian" required>
            <option value="">-- Pilih --</option>
            <option value="0" <?= $isEdit && $edit['isian'] == '0' ? 'selected' : '' ?>>0 - Cek</option>
            <option value="1" <?= $isEdit && $edit['isian'] == '1' ? 'selected' : '' ?>>1 - Lolos</option>
            <option value="2" <?= $isEdit && $edit['isian'] == '2' ? 'selected' : '' ?>>2 - Peringatan (0-50%)</option>
            <option value="3" <?= $isEdit && $edit['isian'] == '3' ? 'selected' : '' ?>>3 - Tidak Lolos (50%)</option>
          </select>
        </div>

        <div class="form-group m-form__group">
          <label for="status">Status</label>
          <select class="form-control m-input" id="status" name="status" required>
            <option value="">-- Pilih --</option>
            <option value="0" <?= $isEdit && $edit['status'] == '0' ? 'selected' : '' ?>>Tidak Aktif</option>
            <option value="1" <?= $isEdit && $edit['status'] == '1' ? 'selected' : '' ?>>Aktif</option>
          </select>
        </div>

        <div class="m-portlet_foot m-portlet_foot--fit">
          <div class="m-form__actions">
            <?php if ($isEdit): ?>
              <button type="button" class="btn btn-primary" onclick="showUpdateModal()">Perbarui</button>
            <?php else: ?>
              <button type="submit" class="btn btn-primary">Simpan</button>
            <?php endif ?>
            <a href="isian-pemutu" class="btn btn-secondary">Batal</a>
          </div>
        </div>
      </form>
      <!--end::Form-->
    </div>
  </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success mt-3"><?= session()->getFlashdata('success') ?></div>
<?php endif ?>

<!-- TABEL DATA -->
<div class="row mt-5">
  <div class="col-md-12">
    <div class="m-portlet">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Daftar Isian Pemutu</h3>
          </div>
        </div>
      </div>
      <div class="m-portlet__body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Unit Pemutu</th>
              <th>Instrumen</th>
              <th>Isian</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($isian_pemutu)): ?>
              <?php $no = 1;
              foreach ($isian_pemutu as $row): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= esc($row['nama_unit']) ?></td>
                  <td><?= esc($row['jenjang_text']) ?></td>
                  <td><?= ['Cek', 'Lolos', 'Peringatan (0-50%)', 'Tidak Lolos (50%)'][$row['isian']] ?></td>
                  <td><?= $row['status'] ? 'Aktif' : 'Tidak Aktif' ?></td>
                  <td>
                    <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <button class="btn btn-sm btn-danger" onclick="showDeleteModal('<?= $row['id'] ?>')">Hapus</button>
                  </td>
                </tr>
              <?php endforeach ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center">Belum ada data.</td>
              </tr>
            <?php endif ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form method="get">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Konfirmasi Hapus</h5>
          <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="delete" id="deleteId">
          <p>Apakah Anda yakin ingin menghapus data ini?</p>
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
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">Konfirmasi Perbarui Data</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">Apakah Anda yakin ingin memperbarui data ini?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" onclick="submitUpdate()">Ya, Perbarui</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Simpan data instrumen dalam JS
  const instrumenData = <?= json_encode(array_column($instrumen_list, null, 'id')) ?>;

  // Ketika dropdown berubah, isi input-input di bawah
  document.getElementById('id_instrumen').addEventListener('change', function () {
    const selectedId = this.value;
    const data = instrumenData[selectedId];

    if (data) {
      document.getElementById('lembaga').value = data.id_lembaga || '';
      document.getElementById('jenjang_instrumen').value = data.jenjang || '';
      document.getElementById('indikator').value = data.indikator || '';
      document.getElementById('kondisi').value = data.kondisi || '';
      document.getElementById('batas').value = data.batas || '';
    } else {
      // Kosongkan jika tidak ada pilihan
      document.getElementById('lembaga').value = '';
      document.getElementById('jenjang_instrumen').value = '';
      document.getElementById('indikator').value = '';
      document.getElementById('kondisi').value = '';
      document.getElementById('batas').value = '';
    }
  });
  function showDeleteModal(id) {
    document.getElementById('deleteId').value = id;
    $('#deleteModal').modal('show');
  }

  function showUpdateModal() {
    $('#updateModal').modal('show');
  }

  function submitUpdate() {
    document.querySelector('form.m-form').submit();
  }
</script>