<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Isian Pemutu Unit
          </h3>
        </div>
      </div>
    </div>

<div class="m-portlet__body">
  <!--begin: Search Form -->
  <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
    <div class="row align-items-center justify-content-between">
      
      <!-- Tombol kiri -->
      <div class="col-xl-4 col-md-12 mb-2 mb-xl-0">
        <a href="<?= site_url('akreditasi/isian-pemutu-unit/input') ?>"
          class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
          <span>
            <i class="flaticon-add"></i>
            <span>Input Isian Unit</span>
          </span>
        </a>
      </div>

      <!-- Filter & Search kanan -->
      <div class="col-xl-8 col-md-12">
        <div class="form-group m-form__group row align-items-center justify-content-end">
          <div class="col-md-5">
            <select id="periodeFilter" class="form-control m-input m-input--solid">
              <option value="">Filter Periode...</option>
              <option value="2021/2022">2021/2022</option>
              <option value="2022/2023">2022/2023</option>
              <option value="2023/2024">2023/2024</option>
              <option value="2024/2025">2024/2025</option>
            </select>
          </div>
          <div class="col-md-5">
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
</div>

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
                <td><?= esc($row['jenjang_text']) ?></td>
                <td><?= esc($row['isian']) ?></td>
                <td><?= $row['status'] ? 'Lolos' : 'Tidak Lolos' ?></td>
                <td>
                  <a href="<?= site_url('akreditasi/isian-pemutu-unit/input?id=' . $row['id']) ?>"
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
  function applyFilters() {
    let searchValue = $('#generalSearch').val().toLowerCase().trim();
    let periodeValue = $('#periodeFilter').val().toLowerCase().trim();

    $('#html_table tbody tr').each(function () {
      let row = $(this);
      let unitPemutu = row.find('td:nth-child(2)').text().toLowerCase();
      let instrumen = row.find('td:nth-child(3)').text().toLowerCase();
      let status = row.find('td:nth-child(5)').text().toLowerCase();

      // Cek apakah periode cocok
      let isPeriodeMatch = periodeValue === "" || unitPemutu.includes(periodeValue);

      // Cek apakah search cocok di salah satu kolom
      let isSearchMatch = false;
      if (searchValue === "") {
        isSearchMatch = true;
      } else if (status === searchValue) {
        isSearchMatch = true;
      } else if (unitPemutu.includes(searchValue) || instrumen.includes(searchValue)) {
        isSearchMatch = true;
      }

      // Tampilkan baris hanya jika dua-duanya cocok
      row.toggle(isPeriodeMatch && isSearchMatch);
    });
  }

  $('#generalSearch').on('keyup', applyFilters);
  $('#periodeFilter').on('change', applyFilters);
});

</script>

<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js"
  type="text/javascript"></script>