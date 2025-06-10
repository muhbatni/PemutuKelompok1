<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">Data Kriteria Akreditasi</h3>
        </div>
      </div>
    </div>

    <div class="m-portlet__body">
      <!-- Tombol Tambah, Filter Lembaga, dan Pencarian -->
      <div class="row mb-4 align-items-center">
        <!-- Tombol Input Kriteria -->
        <div class="col-md-3 mb-2 mb-md-0">
          <a href="<?= site_url('akreditasi/kriteria/input') ?>" class="btn btn-accent w-100">
            <i class="flaticon-add"></i> Input Kriteria
          </a>
        </div>

        <!-- Filter Lembaga -->
        <div class="col-md-5 mb-2 mb-md-0">
          <select id="lembagaFilter" id="generalSearch" class="form-control m-input m-input--solid">
            <option value="">Filter Lembaga...</option>
            <?php foreach ($lembagaList as $lembaga): ?>
              <option value="<?= esc($lembaga['nama']) ?>"><?= esc($lembaga['nama']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Pencarian -->
        <div class="col-md-4">
          <div class="form-group m-form__group mb-0">
            <div class="m-input-icon m-input-icon--left">
              <input type="text" class="form-control m-input m-input--solid" placeholder="Search..." id="generalSearch">
              <span class="m-input-icon__icon m-input-icon__icon--left">
                <span><i class="la la-search"></i></span>
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="table-responsive">
        <table class="table table-bordered table-striped mb-0 w-100" id="kriteriaTable">
          <thead class="thead-dark">
            <tr>
              <th>No</th>
              <th>Lembaga</th>
              <th>Kode</th>
              <th>Nama</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($kriteria)): ?>
              <?php $no = 1;
              foreach ($kriteria as $row): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= esc($row['nama_lembaga']) ?></td>
                  <td><?= esc($row['kode']) ?></td>
                  <td><?= esc($row['nama']) ?></td>
                  <td>
                    <a href="<?= site_url('akreditasi/kriteria/input?id=' . $row['id']) ?>"
                      class="btn btn-sm btn-warning">Edit</a>
                    <button type="button" class="btn btn-sm btn-danger"
                      onclick="showDeleteModal('<?= $row['id'] ?>', '<?= esc($row['nama']) ?>')">
                      Hapus
                    </button>
                  </td>
                </tr>
              <?php endforeach ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center">Belum ada data kriteria.</td>
              </tr>
            <?php endif ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
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
        <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Ya, Hapus</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<script>
  function showDeleteModal(id, nama) {
    document.getElementById('deleteMessage').textContent = `Yakin ingin menghapus kriteria "${nama}"?`;
    document.getElementById('confirmDeleteBtn').href = "<?= site_url('akreditasi/kriteria?delete=') ?>" + id;
    $('#deleteModal').modal('show');
  }

  $(document).ready(function () {
  // Fungsi filter umum
  function filterTable(value) {
    const searchValue = value.toLowerCase();
    $('#kriteriaTable tbody tr').filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
    });
  }

  // General Search
  $('#generalSearch').on('keyup', function () {
    filterTable($(this).val());
  });

  // Filter dari dropdown Lembaga
  $('#lembagaFilter').on('change', function () {
    const selected = $(this).val();
    filterTable(selected); // Langsung panggil filter, tanpa isi input search
  });
});
</script>