<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Isian Pemutu
          </h3>
        </div>
      </div>
    </div>

    <div class="m-portlet__body">
      <!--begin: Search Form -->
      <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
        <div class="row align-items-center">
          <div class="col-xl-4 order-1 order-xl-1 m--align-left">
            <a href="/pemutu/public/akreditasi/isian-pemutu/input"
              class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
              <span>
                <i class="flaticon-add"></i>
                <span>Input Isian</span>
              </span>
            </a>
            <div class="m-separator m-separator--dashed d-xl-none"></div>
          </div>
          <div class="col-xl-8 order-2 order-xl-2">
            <div class="form-group m-form__group row align-items-center justify-content-end">
              <div class="col-md-4">
                <select id="periodeFilter" class="form-control m-input m-input--solid">
                  <option value="">Filter Periode...</option>
                  <?php foreach ($periodeList as $periode): ?>
                    <option value="<?= esc($periode['ts']) ?>"><?= esc($periode['ts']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
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
      <table class="table table-bordered table-striped" id="html_table" width="100%">
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
                <td><?= esc($row['nama_unit']) ?> - <?= esc($row['tahun_ajaran']) ?></td>
                <td><?= esc($row['indikator']) ?></td>
                <td><?= esc($row['isian']) ?></td>
                <td>
                  <?php if ($row['status']): ?>
                    <span class="badge badge-light border border-success text-success py-1 px-2"
                      style="min-width: 100px; display: inline-block; text-align: center;">
                      Lolos
                    </span>
                  <?php else: ?>
                    <span class="badge badge-light border border-danger text-danger py-1 px-2"
                      style="min-width: 100px; display: inline-block; text-align: center;">
                      Tidak Lolos
                    </span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="<?= site_url('akreditasi/isian-pemutu/input?id=' . $row['id']) ?>"
                    class="btn btn-sm btn-warning">Edit</a>
                  <button class="btn btn-sm btn-danger"
                    onclick="showDeleteModal('<?= $row['id'] ?>', '<?= esc($row['nama_unit']) ?>')">Hapus</button>
                </td>
              </tr>
            <?php endforeach ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">Belum ada data isian pemutu.</td>
            </tr>
          <?php endif ?>
        </tbody>
      </table>
      <!--end: Datatable -->
    </div>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
  aria-hidden="true">
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

  $(document).ready(function () {
  // Fungsi filter umum
  function filterTable(value) {
    const searchValue = value.toLowerCase();
    $('#html_table tbody tr').filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
    });
  }

  // General Search
  $('#generalSearch').on('keyup', function () {
    filterTable($(this).val());
  });

  // Filter dari dropdown Lembaga
  $('#periodeFilter').on('change', function () {
    const selected = $(this).val();
    filterTable(selected); // Langsung panggil filter, tanpa isi input search
  });
});
</script>

<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js"
  type="text/javascript"></script>