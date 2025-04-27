<div class="m-content">

  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Data Dokumen
          </h3>
        </div>
      </div>
    </div>

    <div class="m-portlet__body">
      <!--begin: Search Form -->
      <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
        <div class="row align-items-center">
          <div class="col-xl-4 order-1 order-xl-1 m--align-left">
            <a href="input-data-dukung"
              class=" btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
              <span>
                <i class="flaticon-add"></i>
                <span>
                  Tambah Data Dukung
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
            <th title="Field #1">Kode Data Dukung</th>
            <th title="Field #2">Pelaksanaan</th>
            <th title="Field #3">Pernyataan</th>
            <th title="Field #4">Deskripsi</th>
            <th title="Field #5">Dokumen</th>
            <th title="Field #6">Aksi</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach ($dataDukung as $row) : ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['nama_unit']; ?></td>
                    <td><?= $row['pernyataan']; ?></td>
                    <td><?= $row['deskripsi']; ?></td>
                    <td>
                        <a href="<?= base_url('uploads/data_dukung/' . $row['dokumen']); ?>" target="_blank">
                            <?= $row['dokumen']; ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?= base_url('audit/data-dukung/edit/' . $row['id']); ?>" 
                          class="btn btn-sm btn-info" title="Edit">
                            <i class="la la-edit"></i>
                        </a>
                        <a href="<?= base_url('audit/data-dukung/delete/' . $row['id']); ?>" 
                          class="btn btn-sm btn-danger" 
                          onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                          title="Delete">
                            <i class="la la-trash"></i>
                        </a>
                    </td>
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