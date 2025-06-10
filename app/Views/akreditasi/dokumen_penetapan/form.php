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
            action="<?= site_url('akreditasi/dokumen-penetapan') ?>" method="post" enctype="multipart/form-data" id="dokumenForm">
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
          <input type="file" class="form-control m-input" name="dokumen" id="dokumen" accept=".pdf,.doc,.docx" onchange="updateFileName()">
          <?php if ($isEdit && !empty($edit['dokumen'])): ?>
              <div class="mt-2">
                  <strong>File yang diupload: </strong> <?= $edit['dokumen'] ?> 
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

        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
            <a href="<?= base_url('public/akreditasi/dokumen-penetapan') ?>" class="btn btn-danger me-2">
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
      <!--end::Form-->
    </div>
  </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success mt-3">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

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
  const isEdit = <?= $isEdit ? 'true' : 'false' ?>;

  function showDeleteModal(id, nama) {
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteMessage').innerHTML =
      `Apakah Anda yakin ingin menghapus dokumen <strong>${nama}</strong>?`;
    $('#deleteModal').modal('show');
  }

  function showUpdateModal() {
    // Validasi manual sebelum tampilkan modal update
    const nomor = document.getElementById('nomor').value;
    const tanggal = document.getElementById('tanggal').value;
    const nama = document.getElementById('nama').value;

    if (!nomor || !tanggal || !nama) {
      alert('Field Nomor, Tanggal, dan Nama wajib diisi.');
      return;
    }

    $('#updateModal').modal('show');
  }

  function submitUpdate() {
    document.getElementById('dokumenForm').submit();
  }
</script>
