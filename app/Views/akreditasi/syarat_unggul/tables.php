<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Data Syarat Unggul
          </h3>
        </div>
      </div>
    </div>

    <div class="m-portlet__body">
   <!--begin: Search Form -->
<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
  <div class="row align-items-center">
    <!-- Kolom kiri: Tombol -->
    <div class="col-md-4 text-left mb-2">
      <a href="/pemutu/public/akreditasi/syarat-unggul/input"
        class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
        <span>
          <i class="flaticon-add"></i>
          <span>Input Syarat Unggul</span>
        </span>
      </a>
    </div>

    <!-- Kolom tengah: Filter Dropdown -->
    <div class="col-md-4 text-center mb-2">
      <select id="lembagaFilter" class="form-control m-input m-input--solid">
        <option value="">Filter Lembaga...</option>
        <?php foreach ($lembagas as $lembaga): ?>
          <option value="<?= esc($lembaga['id']) ?>"><?= esc($lembaga['nama']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Kolom kanan: Search -->
    <div class="col-md-4 text-right mb-2">
      <div class="m-input-icon m-input-icon--left">
        <input type="text" class="form-control m-input m-input--solid" placeholder="Search..." id="generalSearch">
        <span class="m-input-icon__icon m-input-icon__icon--left">
          <span><i class="la la-search"></i></span>
        </span>
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
            <th>Nama Lembaga</th>
            <th>Nama Syarat Unggul</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($dataSyarat)): ?>
            <?php $no = 1;
            foreach ($dataSyarat as $syarat): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>
                  <?php
                  $lembaga = null;
                  foreach ($lembagas as $l) {
                    if ($l['id'] == $syarat['id_lembaga']) {
                      $lembaga = $l['nama'];
                      break;
                    }
                  }
                  echo $lembaga ? $lembaga : 'Lembaga Tidak Ditemukan';
                  ?>
                </td>
                <td><?= $syarat['nama']; ?></td>
                <td>
                  <a href="<?= site_url('akreditasi/syarat-unggul/input?id=' . $syarat['id']) ?>"
                    class="btn btn-sm btn-warning">Edit</a>
                  <button class="btn btn-sm btn-danger"
                    onclick="showDeleteModal('<?= $syarat['id'] ?>', '<?= esc($syarat['nama']) ?>')">Hapus</button>
                </td>
              </tr>
            <?php endforeach ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center">Belum ada data.</td>
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
  function filterTable(value, columnIndex = null) {
    const searchValue = value.toLowerCase();

    $('#html_table tbody tr').filter(function () {
      if (columnIndex === null) {
        // General search (seluruh baris)
        $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
      } else {
        // Search berdasarkan kolom tertentu
        const cellText = $(this).find('td').eq(columnIndex).text().toLowerCase();
        $(this).toggle(cellText.indexOf(searchValue) > -1);
      }
    });
  }

  // General Search: cari di semua kolom
  $('#generalSearch').on('keyup', function () {
    const value = $(this).val();
    filterTable(value); // tanpa kolomIndex = cari di seluruh baris
  });

  // Filter Nama Lembaga (hanya di kolom 'Nama Lembaga', misalnya kolom ke-2)
  $('#lembagaFilter').on('change', function () {
    const selected = $(this).val();
    if (selected === '') {
      // Kosongkan filter
      $('#html_table tbody tr').show();
    } else {
      filterTable(selected, 0); // kolom index (Nama Lembaga)
    }
    $('#generalSearch').val(''); // kosongkan input search
  });
});

</script>

<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js"
  type="text/javascript"></script>