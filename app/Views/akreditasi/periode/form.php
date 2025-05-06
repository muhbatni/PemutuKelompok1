<?php $isEdit = isset($edit); ?>

<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <h3 class="m-portlet__head-text">Formulir Periode</h3>
          </div>
        </div>
      </div>
      
      <!--begin::Form-->
      <form class="m-form m-form--fit m-form--label-align-right" method="POST" action="<?= site_url('akreditasi/periode') ?>">

        <div class="form-group m-form__group row">
          <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= esc($edit['id']) ?>">
          <?php endif ?>  
        </div>

          <!-- Tahun -->
          <div class="form-group m-form__group row">
            <label for="tahun" class="col-2 col-form-label">Tahun</label>
            <div class="col-10">
              <input class="form-control m-input" type="number" id="tahun" name="tahun" placeholder="Masukkan Tahun" 
              value="<?= $isEdit ? esc($edit['tahun']) : '' ?>" required>
            </div>
          </div>

          <!-- Tahun Ajaran -->
          <div class="form-group m-form__group row">
            <label for="ts" class="col-2 col-form-label">Tahun Ajaran</label>
            <div class="col-10">
              <input class="form-control m-input" type="text" id="ts" name="ts" placeholder="Masukkan Tahun Ajaran" 
              value="<?= $isEdit ? esc($edit['ts']) : '' ?>" required>
            </div>
          </div>

        <!-- Button -->
        <div class="m-portlet__foot m-portlet__foot--fit">
          <div class="m-form__actions">
          <a href="<?= base_url('public/akreditasi/periode') ?>" class="btn btn-danger me-2">
              <i class="fa fa-arrow-left"></i> Batal
          </a>  
          <?php if ($isEdit): ?>
            <button type="button" class="btn btn-primary" onclick="showUpdateModal()">
                <i class="fa fa-save"></i> Perbarui
            </button>
            <?php else: ?>
              <button type="submit" class="btn btn-primary" onclick="submitUpdate()">
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
  <div class="modal-dialog" role="document">
    <form method="post" action="" class="m-form">
      <input type="hidden" name="id" id="updateId">
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
  function showDeleteModal(id, nama) {
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteMessage').innerHTML =
      `Apakah Anda yakin ingin menghapus data <strong>${nama}</strong>?`;
    $('#deleteModal').modal('show');
  }

  function showUpdateModal() {
    $('#updateModal').modal('show');
  }

  function submitUpdate() {
    document.querySelector('form.m-form').submit();
  }
</script>