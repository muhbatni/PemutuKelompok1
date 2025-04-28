<?php $isEdit = isset($edit); ?>

<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Dokumen Penetapan</h3>
          </div>
        </div>
      </div>

      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right"
            action="dokumen-penetapan" method="post" enctype="multipart/form-data">
        <?php if ($isEdit): ?>
          <input type="hidden" name="id" value="<?= esc($edit['id']) ?>">
        <?php endif ?>

          <div class="form-group m-form__group">
            <label for="nomor">Nomor Dokumen</label>
            <input type="text" class="form-control m-input" name="nomor" id="nomor"
                   value="<?= $isEdit ? esc($edit['nomor']) : '' ?>" required>
          </div>

          <div class="form-group m-form__group">
            <label for="tanggal">Tanggal Dokumen</label>
            <input type="date" class="form-control m-input" name="tanggal" id="tanggal"
                   value="<?= $isEdit ? esc($edit['tanggal']) : '' ?>" required>
          </div>

          <div class="form-group m-form__group">
            <label for="nama">Nama Dokumen</label>
            <input type="text" class="form-control m-input" name="nama" id="nama"
                   value="<?= $isEdit ? esc($edit['nama']) : '' ?>" required>
          </div>

          <div class="form-group m-form__group">
            <label for="deskripsi">Deskripsi / Catatan Tambahan</label>
            <textarea class="form-control m-input" name="deskripsi" id="deskripsi"
                      rows="3"><?= $isEdit ? esc($edit['deskripsi']) : '' ?></textarea>
          </div>

          <div class="form-group m-form__group">
            <label for="dokumen">Unggah Dokumen</label>
            <input type="file" class="form-control m-input" name="dokumen" id="dokumen" accept=".pdf,.doc,.docx">
            <span class="m-form__help">
              File yang diperbolehkan: PDF, DOC, DOCX <?= $isEdit && !empty($edit['dokumen']) ? '(Abaikan jika tidak ingin mengganti)' : '' ?>
            </span>
          </div>
        </div>

        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <?php if ($isEdit): ?>
              <button type="button" class="btn btn-primary" onclick="showUpdateModal()">Perbarui</button>
            <?php else: ?>
              <button type="submit" class="btn btn-primary">Simpan</button>
            <?php endif; ?>
            <a href="<?= base_url('public/akreditasi/dokumen-penetapan') ?>" class="btn btn-secondary">Batal</a>
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
            <h3 class="m-portlet__head-text">Daftar Dokumen Penetapan</h3>
          </div>
        </div>
      </div>
      <div class="m-portlet__body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nomor Dokumen</th>
              <th>Tanggal</th>
              <th>Nama Dokumen</th>
              <th>Deskripsi</th>
              <th>File</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($dokumen_penetapan)) : ?>
              <?php $no = 1; foreach ($dokumen_penetapan as $row) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= esc($row['nomor']) ?></td>
                  <td><?= esc($row['tanggal']) ?></td>
                  <td><?= esc($row['nama']) ?></td>
                  <td><?= esc($row['deskripsi']) ?></td>
                  <td>
                      <?php if (!empty($row['dokumen'])): ?>
                        <?php 
                          $ext = pathinfo($row['dokumen'], PATHINFO_EXTENSION);
                          $fileUrl = base_url('uploads/dokumen-penetapan/' . $row['dokumen']);
                        ?>

                        <div class="btn-group" role="group" aria-label="Dokumen Actions">
                          <?php if (strtolower($ext) === 'pdf'): ?>
                            <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-sm btn-info" style="width: 100px; text-align: center;" title="Pratinjau">
                              Pratinjau <!-- Teks "Pratinjau" untuk PDF -->
                            </a>
                          <?php endif; ?>
                          
                          <a href="<?= $fileUrl ?>" download class="btn btn-sm btn-success" style="width: 100px; text-align: center;" title="Download">
                            <i class="la la-download"></i> <!-- ikon Download -->
                          </a>
                        </div>
                      <?php else: ?>
                        <span class="text-muted">Tidak ada file</span>
                      <?php endif; ?>
                  </td>

                  <td>
                    <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <button class="btn btn-sm btn-danger" onclick="showDeleteModal('<?= $row['id'] ?>', '<?= esc($row['nama']) ?>')">Hapus</button>
                  </td>
                </tr>
              <?php endforeach ?>
            <?php else : ?>
              <tr>
                <td colspan="7" class="text-center">Belum ada data dokumen.</td>
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
  function showDeleteModal(id, nama) {
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteMessage').innerHTML =
      `Apakah Anda yakin ingin menghapus dokumen <strong>${nama}</strong>?`;
    $('#deleteModal').modal('show');
  }

  function showUpdateModal() {
    $('#updateModal').modal('show');
  }

  function submitUpdate() {
    document.querySelector('form.m-form').submit();
  }
</script>