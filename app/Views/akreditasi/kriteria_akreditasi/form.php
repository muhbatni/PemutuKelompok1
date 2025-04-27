<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--tab">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">Formulir Kriteria Akreditasi</h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->
            <form class="m-form m-form--fit m-form--label-align-right" action="kriteria" method="post"
                enctype="multipart/form-data">
                <div class="m-portlet__body">

                    <?php if ($isEdit): ?>
                        <input type="hidden" name="id" value="<?= esc($edit['id']) ?>">
                    <?php endif ?>

                    <!-- id_lembaga Field -->
                    <div class="form-group m-form__group">
                        <label for="id_lembaga">Lembaga Akreditasi</label>
                        <select class="form-control m-input" id="id_lembaga" name="id_lembaga">
                            <option value="">-- Pilih Lembaga --</option>
                            <?php foreach ($lembagas as $lembaga): ?>
                                <option value="<?= $lembaga['id']; ?>" <?= (old('id_lembaga') ?? ($isEdit ? $edit['id_lembaga'] : '')) == $lembaga['id'] ? 'selected' : '' ?>>
                                    <?= $lembaga['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Kode Field -->
                    <div class="form-group m-form__group">
                        <label for="kode">Kode</label>
                        <input type="text" name="kode" id="kode" maxlength="255" required placeholder="Masukkan Kode"
                            value="<?= old('kode') ?? ($isEdit ? $edit['kode'] : '') ?>" class="form-control m-input">
                    </div>

                    <!-- Nama Field -->
                    <div class="form-group m-form__group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" maxlength="255" required placeholder="Masukkan Nama"
                            value="<?= old('nama') ?? ($isEdit ? $edit['nama'] : '') ?>" class="form-control m-input">
                    </div>

                    <!-- Submit and Cancel Buttons -->
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            <button type="submit" class="btn btn-primary">
                                <?= $isEdit ? 'Perbarui' : 'Simpan' ?>
                            </button>
                            <button type="reset" class="btn btn-secondary"
                                onclick="window.location.href='<?= $isEdit ? base_url('public/akreditasi/kriteria') : '#' ?>'">
                                Batal
                            </button>
                        </div>
                    </div> <!-- ⬅️ Penutup div tombol -->

            </form> <!-- ⬅️ Ini tutup form yang bener -->

            <!--end::Form-->
        </div>
    </div>
</div>

<!-- TABEL DATA -->
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">Daftar Kriteria Akreditasi</h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body p-0">
                    <form method="post" action="kriteria" class="mb-0">
                        <?= csrf_field() ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0 w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Lembaga</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($kriteria)): ?>
                                        <?php $no = 1;
                                        foreach ($kriteria as $row): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= esc($row['nama_lembaga']) ?></td>
                                                <td><?= esc($row['kode']) ?></td>
                                                <td><?= esc($row['nama']) ?></td>
                                                <td class="d-flex gap-2">
                                                    <a href="?edit=<?= $row['id'] ?>"
                                                        class="btn btn-sm btn-warning mr-1">Edit</a>
                                                    <button type="submit" name="id_delete" value="<?= $row['id'] ?>"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Belum ada data instrumen.</td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>