<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Daftar Data Pemutu
          </h3>
        </div>
      </div>
    </div>

    <div class="m-portlet__body">
      <!--begin: Search Form -->
      <div class="row mb-4 align-items-center">
        <div class="col-md-6 mb-2 mb-md-0">
          <a href=/pemutu/public/akreditasi/input-data-pemutu/input class="btn btn-accent">
            <i class="flaticon-add"></i> Input Data Pemutu
          </a>
        </div>
        <div class="col-md-6">
          <div class="form-group m-form__group mb-0">
            <div class="m-input-icon m-input-icon--left">
              <input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
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
            <th>Unit</th>
            <th>Periode</th>
            <th>Lembaga</th>
            <th>Status</th>
            <th>Tanggal Input</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($data_pemutu)): ?>
            <tr>
              <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
          <?php else: ?>
            <?php foreach ($data_pemutu as $index => $data): ?>
              <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($data['unit']) ?></td>
                <td><?= htmlspecialchars($data['periode']) ?></td>
                <td><?= htmlspecialchars($data['lembaga']) ?></td>
                <td>
                  <span class="<?= $data['status_class'] ?>">
                    <?= $data['status'] ?>
                  </span>
                </td>
                <td><?= date('d/m/Y H:i', strtotime($data['created_at'])) ?></td>
                <td>
                  <a href="<?= base_url('public/akreditasi/input-data-pemutu/edit/' . $data['id']) ?>"
                    class="btn btn-sm btn-warning">
                    Edit
                  </a>
                  <a href="<?= base_url('public/akreditasi/input-data-pemutu/delete/' . $data['id']) ?>"
                    class="btn btn-sm btn-danger"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
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
  // Fungsi untuk filter data berdasarkan periode
  $(document).ready(function () {
    $('#generalSearch').on('keyup', function () {
      let searchValue = $(this).val().toLowerCase();
      $('#html_table tbody tr').each(function () {
        // Ambil nilai dari kolom periode (kolom ke-3)
        let periodeValue = $(this).find('td:eq(2)').text().toLowerCase();
        // Toggle tampilan baris berdasarkan kecocokan dengan periode
        $(this).toggle(periodeValue.includes(searchValue));
      });
    });
  });

  // Fungsi untuk menampilkan lembaga berdasarkan unit
  document.getElementById('id_unit').addEventListener('change', function () {
    const unitId = this.value;
    const lembagaDisplay = document.getElementById('lembaga_display');
    const idLembagaInput = document.getElementById('id_lembaga');

    if (unitId) {
      fetch(`<?= site_url('akreditasi/input-data-pemutu/get-lembaga') ?>/${unitId}`)
        .then(response => response.json())
        .then(data => {
          if (data && data.id && data.nama) {
            lembagaDisplay.textContent = data.nama;
            idLembagaInput.value = data.id;
          } else {
            lembagaDisplay.textContent = '–';
            idLembagaInput.value = '';
          }
        })
        .catch(() => {
          lembagaDisplay.textContent = '–';
          idLembagaInput.value = '';
        });
    } else {
      lembagaDisplay.textContent = '–';
      idLembagaInput.value = '';
    }
  });

  <?php if (isset($editData)): ?>
    document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('id_unit').dispatchEvent(new Event('change'));
    });
  <?php endif; ?>
</script>

<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js"
  type="text/javascript"></script>