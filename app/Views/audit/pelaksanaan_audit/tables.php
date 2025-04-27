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
          <div class="col-xl-12 order-2 order-xl-2">
            <div class="form-group m-form__group row align-items-center">
              <div class="col-md-4 ml-auto">
                <div class="m-input-icon m-input-icon--left">
                  <input type="text" class="form-control m-input m-input--solid" placeholder="Search..."
                    id="generalSearch">
                  <span class="m-input-icon__icon m-input-icon__icon--left">
                    <span>
                      <i class="la la-search"></i>
                    </span>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--end: Search Form -->
      <!--begin: Datatable -->

      <div class="table-responsive">
        <table class="table table-striped m-table" id="html_table">
          <thead class="thead-light">
            <tr>
              <th width="5%"></th>
              <th>Kode Audit</th>
              <th>Periode</th>
              <th>Standar</th>
              <th>Auditor</th>
              <th>Unit</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pelaksanaan_audit as $data): ?>
              <tr class="main-row">
                <td class="text-center">
                  <button type="button" class="btn btn-primary btn-sm toggle-action"
                    data-id="<?= $data->id_audit; ?>">+</button>
                </td>
                <td><?= esc($data->kode_audit); ?></td>
                <td><?= esc($data->tahun_periode); ?></td>
                <td><?= esc($data->nama_standar); ?></td>
                <td>
                  <?php if ($data->id_auditor !== 'Belum dipilih'): ?>
                    <?= esc($data->id_auditor); ?>
                  <?php else: ?>
                    Belum dipilih
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($data->id_unit !== 'Belum dipilih'): ?>
                    <?= esc($data->id_unit); ?>
                  <?php else: ?>
                    Belum dipilih
                  <?php endif; ?>
                </td>
              </tr>
              <tr class="action-row" id="action-<?= $data->id_audit; ?>" style="display:none;">
                <td colspan="6" class="text-center">
                  <a href="<?= base_url('public/audit/pelaksanaan-audit/edit/' . $data->id_audit); ?>"
                    class="btn btn-success">
                    Lakukan Audit
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
    // Add click event to all toggle buttons
    var toggleButtons = document.querySelectorAll('.toggle-action');

    toggleButtons.forEach(function (button) {
      button.addEventListener('click', function () {
        var id = this.getAttribute('data-id');
        var actionRow = document.getElementById('action-' + id);

        if (actionRow.style.display === 'none') {
          actionRow.style.display = 'table-row';
          this.textContent = '-';
        } else {
          actionRow.style.display = 'none';
          this.textContent = '+';
        }
      });
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