<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="m-content">
  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Tabel Pelaksanaan Audit
          </h3>
        </div>
      </div>
    </div>

    <div class="m-portlet__body">
      <!--begin: Search Form -->
      <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
        <div class="row align-items-center">
          <div class="col-md-4">
            <label for="filterJudulAudit">Audit</label>
            <select id="filterJudulAudit" class="form-control m-input m-input--solid">
              <option value="">Semua</option>
              <?php foreach ($list_audit as $audit): ?>
                <option value="<?= esc($audit['id']); ?>" <?= ($audit['id'] == ($_GET['id'] ?? '')) ? 'selected' : '' ?>>
                  <?= esc($audit['kode']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-xl-4 ml-auto text-right">
            <a id="btnTambahAudit" href="#"
              class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" data-bs-toggle="modal"
              data-bs-target="#modalTambahPelaksanaan">
              <span>
                <i class="flaticon-add"></i>
                <span>
                  Tambah Pelaksanaan Audit
                </span>
              </span>
            </a>
            <div class="m-separator m-separator--dashed d-xl-none"></div>
          </div>
        </div>
      </div>
      <!--end: Search Form -->
      <!--begin: Datatable -->

      <div class="table-responsive">
        <table class="table table-striped m-table" id="html_table">
          <thead class="thead-light">
            <tr>
              <th>Judul Audit</th>
              <th>Auditor</th>
              <th>Unit</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pelaksanaan_audit as $data): ?>
              <tr data-id-audit="<?= esc($data['id_audit']); ?>">
                <td><?= esc($data['kode_audit']); ?></td>
                <td>
                  <?= !empty($data['nama_auditor']) ? esc($data['nama_auditor']) : 'Belum dipilih'; ?>
                </td>
                <td>
                  <?= !empty($data['nama_unit']) ? esc($data['nama_unit']) : 'Belum dipilih'; ?>
                </td>
                <td>
                  <a href="<?= base_url('public/audit/pelaksanaan-audit/edit/' . $data['id_standar_audit']); ?>"
                    class="btn btn-success btn-sm">
                    Laksanakan Audit
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!--end: Datatable -->
    </div>
  </div>
</div>

<!-- Modal Tambah Pelaksanaan Audit -->
<div class="modal fade" id="modalTambahPelaksanaan" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= base_url('public/audit/pelaksanaan-audit/simpan') ?>" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Pilih Auditor dan Unit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_standar_audit" id="inputIdStandarAudit" value="">
          <input type="hidden" name="id_audit" id="inputIdAudit">

          <div class="mb-3">
            <div id="standarContainer" class="form-control" readonly></div>
          </div>

          <div class="mb-3">
            <label for="id_unit" class="form-label">Unit</label>
            <select name="id_unit" class="form-control m-input m-input--solid" required>
              <?php foreach ($unit_list as $unit): ?>
                <option value="<?= $unit->id_unit ?>"><?= $unit->nama_unit ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="id_auditor" class="form-label">Auditor</label>
            <select name="id_auditor" class="form-control m-input m-input--solid" required>
              <?php foreach ($auditor_list as $auditor): ?>
                <option value="<?= $auditor->id_auditor ?>"><?= $auditor->nama_auditor ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const filterJudulAudit = document.getElementById('filterJudulAudit');
    const btnTambahAudit = document.getElementById('btnTambahAudit');
    const rows = document.querySelectorAll('#html_table tbody tr');

    function filterTable(selectedValue) {
      rows.forEach(function (row) {
        const rowIdAudit = row.getAttribute('data-id-audit');
        const isVisible = !selectedValue || rowIdAudit === selectedValue;
        row.style.display = isVisible ? '' : 'none';
      });

    }

    // Trigger initial filter (pakai ?id=... di URL jika ada)
    const urlParams = new URLSearchParams(window.location.search);
    const initialId = urlParams.get('id');
    if (initialId) {
      filterJudulAudit.value = initialId;
      filterTable(initialId);
    }

    // Event listener untuk perubahan dropdown
    filterJudulAudit.addEventListener('change', function () {
      filterTable(this.value);
      // Update URL (opsional, agar bisa dishare)
      const newUrl = new URL(window.location.href);
      if (this.value) {
        newUrl.searchParams.set('id', this.value);
      } else {
        newUrl.searchParams.delete('id');
      }
      window.history.replaceState({}, '', newUrl);
      // TAMPILKAN VALUE DI CONSOLE
      console.log('Value dropdown Audit:', this.value);
    });
  });

  document.getElementById('btnTambahAudit').addEventListener('click', function (e) {
    e.preventDefault();
    // Ambil value dari dropdown Audit
    const selectedAuditId = document.getElementById('filterJudulAudit').value;
    // Hapus value inputIdStandarAudit setiap kali modal dibuka
    document.getElementById('inputIdStandarAudit').value = '';
    document.getElementById('inputIdAudit').value = selectedAuditId;
    // (Optional) tampilkan kode audit di standarContainer
    const selectedOption = document.getElementById('filterJudulAudit').options[document.getElementById('filterJudulAudit').selectedIndex];
    document.getElementById('standarContainer').textContent = selectedOption.text !== 'Semua' ? selectedOption.text : '';
    // Tampilkan modal
    const modal = new bootstrap.Modal(document.getElementById('modalTambahPelaksanaan'));
    modal.show();
  });
</script>




<style>
  .table-responsive {
    overflow-x: auto;
  }

  .action-row {
    background-color: #f5f5f5;
  }

  .table th,
  .table td {
    vertical-align: middle;
  }

  .thead-light th {
    background-color: #f8f9fa;
    color: #495057;
  }

  .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.02);
  }

  .table-striped tbody tr:nth-of-type(even) {
    background-color: #ffffff;
  }
</style>