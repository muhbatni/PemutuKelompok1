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
                <td class="status-cell" data-id="<?= $row['id']; ?>">
                  <?php
                  $currentStatus = $row['status'] ?? '0'; // Default ke '0' (Belum Ditindaklanjuti)
                  if ($currentStatus === '0') {
                    echo '<span class="badge badge-pill badge-danger px-3 py-2 status-badge" style="font-weight: 500; white-space: normal;">Belum Ditindaklanjuti</span>';
                  } elseif ($currentStatus === '1') {
                    echo '<span class="badge badge-pill badge-warning px-3 py-2 status-badge" style="font-weight: 500; white-space: normal;">Sedang Ditindaklanjuti</span>';
                  } elseif ($currentStatus === '2') {
                    echo '<span class="badge badge-pill badge-success px-3 py-2 status-badge" style="font-weight: 500; white-space: normal;">Selesai</span>';
                  }
                  ?>
                </td>
                <td>
                  <a href="<?= base_url('public/audit/input-temuan/edit/' . $row['id']); ?>"
                    class="btn btn-sm btn-warning mb-1" title="Edit">
                    <i class="la la-edit"></i>
                  </a>
                  <a href="<?= base_url('public/audit/input-temuan/delete/' . $row['id']); ?>"
                    class="btn btn-sm btn-danger mb-1" title="Hapus"
                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                    <i class="la la-trash"></i>
                  </a>
                  <div class="status-action-group" data-id="<?= $row['id']; ?>">
                    <span class="status-icon-box status-0 <?= ($currentStatus === '0') ? 'selected' : '' ?>"
                      data-status-value="0" title="Belum Ditindaklanjuti">
                      <i class="la la-times"></i>
                    </span>
                    <span class="status-icon-box status-1 <?= ($currentStatus === '1') ? 'selected' : '' ?>"
                      data-status-value="1" title="Sedang Ditindaklanjuti">
                      <i class="la la-hourglass-half"></i>
                    </span>
                    <span class="status-icon-box status-2 <?= ($currentStatus === '2') ? 'selected' : '' ?>"
                      data-status-value="2" title="Selesai">
                      <i class="la la-check"></i>
                    </span>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<style>
  /* Mengatur tombol aksi agar sejajar dan memiliki sedikit margin bawah */
  td>.btn.btn-sm {
    margin-right: 5px;
    /* Jarak antara tombol edit/hapus dan grup status */
    vertical-align: middle;
    /* Pastikan mereka sejajar secara vertikal */
  }

  .status-action-group {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    /* Mengurangi jarak antar kotak ikon */
    margin-top: 5px;
    /* Tambahkan sedikit jarak atas dari tombol Edit/Hapus jika perlu */
    vertical-align: middle;
    /* Sejajarkan dengan tombol di atasnya */
  }

  .status-icon-box {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    /* Mengurangi ukuran lebar kotak */
    height: 26px;
    /* Mengurangi ukuran tinggi kotak */
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    /* Sedikit mengurangi lengkungan sudut */
    cursor: pointer;
    background-color: #f8f9fa;
    transition: all 0.2s ease-in-out;
    color: #6c757d;
  }

  .status-icon-box i {
    font-size: 1rem;
    /* Mengurangi ukuran ikon di dalam kotak */
  }

  /* Styling untuk ikon yang terpilih (selected) */
  .status-icon-box.selected {
    border-color: transparent;
    color: #fff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    /* Mengurangi bayangan */
  }

  /* Warna latar belakang dan border untuk status 0 (Belum Ditindaklanjuti) */
  .status-icon-box.status-0.selected {
    background-color: #dc3545;
    /* Merah */
  }

  /* Warna latar belakang dan border untuk status 1 (Sedang Ditindaklanjuti) */
  .status-icon-box.status-1.selected {
    background-color: #ffc107;
    /* Kuning/Orange */
  }

  /* Warna latar belakang dan border untuk status 2 (Selesai) */
  .status-icon-box.status-2.selected {
    background-color: #28a745;
    /* Hijau */
  }

  /* Hover effect untuk kotak ikon */
  .status-icon-box:hover {
    background-color: #e2e6ea;
    border-color: #c8cbce;
    color: #495057;
  }

  /* Hover effect untuk kotak ikon yang selected */
  .status-icon-box.selected:hover {
    opacity: 0.9;
  }
</style>

<script src="<?= base_url(); ?>/public/assets/demo/default/custom/components/datatables/base/html-table.js"
  type="text/javascript"></script>

<script type="text/javascript">
  $(document).ready(function () {
    $('.status-icon-box').on('click', function () {
      var clickedBox = $(this);
      var temuanId = clickedBox.closest('.status-action-group').data('id');
      var newStatusValue = String(clickedBox.data('status-value'));

      // Temukan grup ikon status untuk baris ini
      var actionGroup = clickedBox.closest('.status-action-group');

      // AJAX call to update status in database
      $.ajax({
        url: '<?= base_url("/public/audit/temuan/update-temuan-status"); ?>', // Ganti dengan URL endpoint Anda
        method: 'POST',
        data: {
          id: temuanId,
          status: newStatusValue
        },
        success: function (response) {
          if (response.success) {
            // --- Update UI on success ---

            // 1. Update the badge in the "Status" column
            var row = clickedBox.closest('tr');
            var statusCell = row.find('.status-cell');
            var statusBadgeElement = statusCell.find('.status-badge');
            var newBadgeText = '';
            var newBadgeClass = '';

            if (newStatusValue == '0') {
              newBadgeText = 'Belum Ditindaklanjuti';
              newBadgeClass = 'badge-danger';
            } else if (newStatusValue == '1') {
              newBadgeText = 'Sedang Ditindaklanjuti';
              newBadgeClass = 'badge-warning';
            } else if (newStatusValue == '2') {
              newBadgeText = 'Selesai';
              newBadgeClass = 'badge-success';
            }
            console.log("Updating badge for ID:", temuanId, "to", newBadgeText, newBadgeClass);
            console.log("Current statusBadgeElement:", statusBadgeElement);
            console.log("statusCell HTML:", statusCell.html());

            if (statusBadgeElement.length === 0) {
              // Jika tidak ketemu, update seluruh isi statusCell
              statusCell.html('<span class="badge badge-pill ' + newBadgeClass + ' px-3 py-2 status-badge" style="font-weight: 500; white-space: normal;">' + newBadgeText + '</span>');
            } else {
              statusBadgeElement.text(newBadgeText)
                .removeClass('badge-danger badge-warning badge-success')
                .addClass(newBadgeClass);
            }

            // 2. Update the selected icon box in the "Aksi" column
            // Hapus kelas 'selected' dari semua kotak ikon di grup ini
            actionGroup.find('.status-icon-box').removeClass('selected');

            // Tambahkan kelas 'selected' ke kotak ikon yang diklik
            clickedBox.addClass('selected');

            // Opsional: Tampilkan pesan sukses
            // alert('Status berhasil diperbarui!');
          } else {
            // Handle error
            alert('Gagal memperbarui status: ' + response.message);
          }
        },
        error: function (xhr, status, error) {
          alert('Terjadi kesalahan saat berkomunikasi dengan server.');
          console.error(xhr.responseText);
        }
      });
    });
  });
</script>