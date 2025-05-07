<div class="m-content">

  <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <h3 class="m-portlet__head-text">
            Data Standar Audit
          </h3>
        </div>
      </div>
    </div>

    <div class="m-portlet__body">
      <!--begin: Search Form -->
      <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
        <div class="row align-items-center">
          <div class="col-xl-4 order-1 order-xl-1 m--align-left">
            <a href="/pemutu/public/audit/input-standar"
              class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
              <span>
                <i class="flaticon-add"></i>
                <span>
                  Tambah Standar
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
      <div class="table-responsive">
        <table class="table table-striped m-table" id="html_table">
          <thead class="thead-light">
            <tr>
              <th width="5%"></th>
              <!-- <table class="m-datatable" id="html_table" width="100%">
        <thead>
          <tr>
            <th width="5%"></th> -->
              <th title="Field #1">
                Judul
              </th>
              <th title="Field #2">
                Parent
              </th>
              <th title="Field #3">
                Dokumen
              </th>
              <th title="Field #4">
                Status Aktif
              </th>
              <th title="Field #5">
                Aksi
              </th>


            </tr>
          </thead>
          <tbody>
            <?php foreach ($standar as $s): ?>
              <tr class="main-row">
                <td class="text-center">
                  <!-- Tombol untuk toggle pernyataan standar dan indikator -->
                  <!-- <button type="button" class="btn btn-primary btn-sm toggle-action" data-id="<?= $s['id']; ?>">+</button> -->
                  <a href="<?= base_url('public/audit/standar/edit/' . $s['id']); ?>" class="btn btn-primary btn-sm">
                    +
                  </a>
                </td>
                <td><?= $s['nama']; ?></td>
                <!-- <td><?= isset($parentOptions[$s['id_parent']]) ? $parentOptions[$s['id_parent']] : 'Tidak Diketahui'; ?>
                </td> -->

                <td><?= $s['id_parent']?></td>
                <!-- <td><?= $s['dokumen']; ?></td> -->
                <td>
    <?php if (!empty($s['dokumen'])): ?>
        <a href="<?= base_url('public/audit/standar/download/' . $s['dokumen']); ?>" class="btn btn-sm btn-info" title="Download">
            <i class="la la-download"></i> Download
        </a>
    <?php else: ?>
        <span class="text-muted">Tidak Ada Dokumen</span>
    <?php endif; ?>
</td>
                <td>
                  <?php
                  if (isset($s['is_aktif'])) {
                    $aktif = ($s['is_aktif'] === 't') ? 'Aktif' : 'Tidak Aktif';

                  } else {
                    $aktif = 'Tidak Aktif';
                  }
                  echo $aktif
                    ?>
                </td>

                <td class="text-center">
                  <a href="<?= base_url('public/audit/input-standar/edit/' . $s['id']); ?>" class="btn btn-sm btn-warning"
                    title="Edit">
                    <i class="la la-edit"></i>
                  </a>
                  <button class="btn btn-sm btn-danger"
                    onclick="showDeleteModal('<?= $s['id'] ?>', '<?= esc($s['nama']) ?>')" title="Hapus">
                    <i class="la la-trash"></i> <!-- Icon hapus -->
                  </button>
                </td>
              </tr>

              </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
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
        document.addEventListener('DOMContentLoaded', function () {
          // Menambahkan event listener ke tombol toggle (+)
          var toggleButtons = document.querySelectorAll('.toggle-action');

          toggleButtons.forEach(function (button) {
            button.addEventListener('click', function () {
              var id = this.getAttribute('data-id'); // Mengambil ID dari tombol yang diklik
              var actionRow = document.getElementById('action-' + id); // Menargetkan baris aksi yang sesuai dengan ID

              // Memeriksa apakah baris aksi saat ini disembunyikan atau tidak
              if (actionRow.style.display === 'none' || actionRow.style.display === '') {
                actionRow.style.display = 'table-row'; // Menampilkan baris aksi
                this.textContent = '-'; // Mengubah teks tombol menjadi '-'
              } else {
                actionRow.style.display = 'none'; // Menyembunyikan baris aksi
                this.textContent = '+'; // Mengubah teks tombol kembali menjadi '+'
              }
            });
          });
        });



        function showDeleteModal(id, nama) {
          document.getElementById('deleteId').value = id;
          document.getElementById('deleteMessage').innerHTML =
            `Apakah Anda yakin ingin menghapus standar <strong>${nama}</strong>?`;
          $('#deleteModal').modal('show');
        }
      </script>

      <!--end: Datatable -->
    </div>
  </div>
</div>

<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js"
  type="text/javascript"></script>

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