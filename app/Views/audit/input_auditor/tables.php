<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Data Auditor
          </h3>
        </div>
      </div>
    </div>

    <div class="m-portlet__body">
      <!--begin: Search Form -->
      <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
        <div class="row align-items-center">
          <div class="col-xl-4 order-1 order-xl-1 m--align-left">
            <a href="/pemutu/public/audit/auditor/input-auditor"
              class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
              <span>
                <i class="flaticon-add"></i>
                <span>Tambah Data Auditor</span>
              </span>
            </a>
            <div class="m-separator m-separator--dashed d-xl-none"></div>
          </div>
          <div class="col-xl-8 order-2 order-xl-2">
            <div class="form-group m-form__group row align-items-center">
              <div class="col-md-4 ml-auto">
                <div class="m-input-icon m-input-icon--left">
                  <input type="text" class="form-control m-input m-input--solid" placeholder="Search..."
                    id="generalSearch">
                  <span class="m-input-icon__icon m-input-icon__icon--left">
                    <span><i class="la la-search"></i></span>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--end: Search Form -->

      <!--begin: Datatable -->
      <table class="m-datatable" id="html_table" width="100%">
        <thead>
          <tr>
            <th>Username</th>
            <th>File Dokumen</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($auditor as $row): ?>
            <tr>
              <td><?= esc($row['username']); ?></td>
              <td>
                <?= esc($row['dokumen']); ?>
              </td>
              <td>
                  <a href="<?= base_url('public/audit/auditor/input-auditor/' . $row['id']); ?>" class="btn btn-sm btn-warning">
                      Edit <i class="la la-edit"></i>
                  </a>
                  <button class="btn btn-sm btn-danger" onclick="showDeleteModal('<?= $row['id'] ?>', '<?= esc($row['username']) ?>')">
                      Hapus
                  </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <!--end: Datatable -->
    </div>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form id="deleteForm" method="post" action="">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
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

<script>
  function showDeleteModal(id, username) {
    document.getElementById('deleteMessage').innerHTML =
      `Apakah Anda yakin ingin menghapus auditor <strong>${username}</strong>?`;
    document.getElementById('deleteForm').action = '<?= base_url('public/audit/auditor/input-auditor/delete/'); ?>' + id;
    $('#deleteModal').modal('show');
  }
</script>

<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js" type="text/javascript"></script>
