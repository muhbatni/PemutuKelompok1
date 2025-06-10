<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">Data Instrumen Pemutu</h3>
        </div>
      </div>
    </div>

    ```
    <div class="m-portlet__body">
      <!-- Tombol Tambah, Filter, dan Search -->
<div class="row mb-4 align-items-center">
  <!-- Tombol Input -->
  <div class="col-md-4 mb-2 mb-md-0">
    <a href="instrumen-pemutu/input" class="btn btn-accent">
      <i class="flaticon-add"></i> Input Instrumen
    </a>
  </div>

  <!-- Filter Lembaga -->
  <div class="col-md-4 mb-2 mb-md-0">
    <select id="lembagaFilter" class="form-control m-input m-input--solid">
      <option value="">Filter Lembaga...</option>
      <?php foreach ($lembagas as $lembaga): ?>
        <option value="<?= esc($lembaga['nama']) ?>"><?= esc($lembaga['nama']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Search -->
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
        <form method="get" action="<?= base_url('public/akreditasi/instrumen-pemutu') ?>">
          <?= csrf_field() ?>
          <table class="table table-bordered table-striped mb-0 w-100" id="instrumenTable">
            <thead class="thead-dark">
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
                    <td><?= esc($row['jenjang_text']) ?></td>
                    <td><?= esc($row['indikator']) ?></td>
                    <td><?= esc($row['kondisi']) ?></td>
                    <td><?= esc($row['batas']) ?></td>
                    <td>
                      <a href="<?= site_url('akreditasi/instrumen-pemutu/input?id=' . $row['id']) ?>"
                        class="btn btn-sm btn-warning">Edit</a>
                      <button type="button" class="btn btn-sm btn-danger"
                        onclick="showDeleteModal('<?= $row['id'] ?>', '<?= esc($row['jenjang_text']) ?>')">
                        Hapus
                      </button>
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
        </form>
      </div>
    </div>
    ```

  </div>
</div>

<!-- Opsional: Script Search -->

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form method="get" action="<?= site_url('akreditasi/instrumen-pemutu') ?>">
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
  function showDeleteModal(id, jenjang) {
    // Isi pesan konfirmasi dengan jenjang atau info lain
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteMessage').textContent = `Yakin ingin menghapus instrumen jenjang ${jenjang}?`;

    // Tampilkan modal Bootstrap
    $('#deleteModal').modal('show');
  }

 $(document).ready(function () {
  // Fungsi filter umum
  function filterTable(value) {
    const searchValue = value.toLowerCase();
    $('#instrumenTable tbody tr').filter(function () {
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