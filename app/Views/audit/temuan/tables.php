<div class="m-content">

  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Tabel Temuan
          </h3>
        </div>
      </div>
    </div>

    <div class="m-portlet__body">
      <!--begin: Search Form -->
      <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
        <div class="row align-items-center">
          <div class="col-xl-4 order-1 order-xl-1 m--align-left">
            <a href="/pemutu/public/audit/input-temuan"
              class=" btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
              <span>
                <i class="flaticon-add"></i>
                <span>
                  Tambah Temuan
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
      <div class="table-container">
        <table class="m-datatable" id="html_table" width="100%">
          <thead>
            <tr>
              <th title="Field #2">
                Unit
              </th>
              <th title="Field #3">
                Kondisi
              </th>
              <th title="Field #4">
                Rencana Perbaikan
              </th>
              <th title="Field #5">
                Tanggal Perbaikan
              </th>
              <th title="Field #6">
                Catatan
              </th>
              <th title="Field #7">
                Status
              </th>
              <th title="Field #9">
                Aksi
              </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($temuan as $row): ?>
              <tr>
                <td><?= $row['nama_unit']; ?></td>
                <td><?= $row['kondisi']; ?></td>
                <td><?= $row['rencana_perbaikan']; ?></td>
                <td><?= $row['tanggal_perbaikan']; ?></td>
                <td><?= $row['catatan'] ?? '-' ?></td>
                <td>
                  <?php
                  if (isset($row['status']) && $row['status'] === '0') {
                    echo '<span class="badge badge-pill badge-danger px-3 py-2" style="font-weight: 500; white-space: normal;">Belum Ditindaklanjuti</span>';
                  } elseif (isset($row['status']) && $row['status'] === '1') {
                    echo '<span class="badge badge-pill badge-warning px-3 py-2" style="font-weight: 500; white-space: normal;">Sedang Ditindaklanjuti</span>';
                  } elseif (isset($row['status']) && $row['status'] === '2') {
                    echo '<span class="badge badge-pill badge-success px-3 py-2" style="font-weight: 500; white-space: normal;">Selesai</span>';
                  } else {
                    echo '<span class="badge badge-pill badge-secondary px-3 py-2" style="font-weight: 500; white-space: normal;">Belum Diisi</span>';
                  }
                  ?>
                </td>
                <td>
                  <a href="<?= base_url('public/audit/input-temuan/edit/' . $row['id']); ?>"
                    class="btn btn-sm btn-warning" title="Edit">
                    <i class="la la-edit"></i>
                  </a>
                  <a href="<?= base_url('public/audit/input-temuan/delete/' . $row['id']); ?>"
                    class="btn btn-sm btn-danger" title="Hapus"
                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                    <i class="la la-trash"></i>
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

<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js"
  type="text/javascript"></script>