<div class="m-content">

  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Tabel Manajemen Audit
          </h3>
        </div>
      </div>
    </div>

    <div class="m-portlet__body">
      <!--begin: Search Form -->
      <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
        <div class="row align-items-center">
          <div class="col-xl-4 order-1 order-xl-1 m--align-left">
            <a href="input-manajemen-audit"
              class=" btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
              <span>
                <i class="flaticon-add"></i>
                <span>
                  Tambah Audit
                </span>
              </span>
            </a>
            <div class="m-separator m-separator--dashed d-xl-none"></div>
          </div>
          <div class="col-xl-8 order-2 order-xl-2">
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

      <table class="m-datatable" id="html_table" width="100%">
        <thead>
          <tr>
            <th title="Field #1">
              Kode Audit
            </th>
            <th title="Field #2">
              Standar
            </th>
            <th title="Field #3">
              Periode
            </th>
            <th title="Field #4">
              Tanggal Mulai
            </th>
            <th title="Field #5">
              Tanggal Selesai
            </th>
            <th title="Field #5">
              Status
            </th>
            <th title="Field #6">
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($audit_standar as $audit): ?>
            <tr>
              <td><?= $audit->kode_audit; ?></td>
              <td><?= $audit->nama_standar; ?></td>
              <td><?= $audit->tahun_periode; ?></td>
              <td><?= $audit->tanggal_mulai; ?></td>
              <td><?= $audit->tanggal_selesai; ?></td>
              <td><?= $audit->is_aktif; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>

      </table>
      <!--end: Datatable -->
    </div>
  </div>
</div>

<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js"
  type="text/javascript"></script>