<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Dokumen yang terlampir
          </h3>
        </div>
      </div>
    </div>

    <div class="m-portlet__body">
      <!--begin: Search Form -->
      <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
        <div class="row align-items-center">
          <div class="col-xl-4 order-1 order-xl-1 m--align-left">
            <a href="/pemutu/public/akreditasi/dokumen-penetapan/input" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
              <span>
                <i class="flaticon-add"></i>
                <span>Input Dokumen</span>
              </span>
            </a>
            <div class="m-separator m-separator--dashed d-xl-none"></div>
          </div>
          <div class="col-xl-8 order-2 order-xl-2">
            <div class="form-group m-form__group row align-items-center">
              <div class="col-md-4 ml-auto">
                <div class="m-input-icon m-input-icon--left">
                  <input type="text" class="form-control m-input m-input--solid" placeholder="Search..." id="generalSearch">
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
      <table class="table table-bordered table-striped" id="html_table" width="100%">
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
                <td class="text-center">
                  <?php if (!empty($row['dokumen'])): ?>
                    <a href="<?= site_url('akreditasi/dokumen-penetapan/download/' . urlencode($row['dokumen'])) ?>" class="btn btn-sm btn-primary">
                      <i class="fa fa-download"></i> Download
                    </a>
                  <?php else: ?>
                    <span class="text-muted">Tidak ada file</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="<?= site_url('akreditasi/dokumen-penetapan/input?id=' . $row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
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
      <!--end: Datatable -->
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

<script>
  function showDeleteModal(id, nama) {
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteMessage').innerHTML =
      `Apakah Anda yakin ingin menghapus dokumen <strong>${nama}</strong>?`;
    $('#deleteModal').modal('show');
  }

  $(document).ready(function() {
    $('#generalSearch').on('keyup', function() {
      let value = $(this).val().toLowerCase();
      $('#html_table tbody tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>

<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js" type="text/javascript"></script>