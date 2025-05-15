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
            <a id="btnTambahAudit" href="<?= base_url('public/audit/pelaksanaan-audit/edit'); ?>"
              class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
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

      // Update tombol Tambah
      btnTambahAudit.href = selectedValue
        ? "<?= base_url('public/audit/pelaksanaan-audit/edit'); ?>/" + encodeURIComponent(selectedValue)
        : "<?= base_url('public/audit/pelaksanaan-audit/edit'); ?>";
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
    });
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