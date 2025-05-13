<?php $isEdit = isset($edit); ?>

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
            <form class="m-form m-form--fit m-form--label-align-right"
                action="<?= site_url('akreditasi/kriteria/input' . ($isEdit ? '?id=' . $edit['id'] : '')) ?>"
                method="post" enctype="multipart/form-data" id="kriteriaForm">
                <?= csrf_field() ?>
                <?php if ($isEdit): ?>
                    <input type="hidden" name="id" value="<?= esc($edit['id']) ?>">
                <?php endif ?>

                <!-- Lembaga Akreditasi -->
                <div class="form-group m-form__group">
                    <label for="id_lembaga">Lembaga Akreditasi</label>
                    <select class="form-control m-input" id="id_lembaga" name="id_lembaga" required>
                        <option value="">-- Pilih Lembaga --</option>
                        <?php foreach ($lembagas as $lembaga): ?>
                            <option value="<?= $lembaga['id'] ?>" <?=
                                  (old('id_lembaga')
                                      ?? ($isEdit ? $edit['id_lembaga'] : ($selected_lembaga ?? ''))) == $lembaga['id']
                                  ? 'selected' : ''
                                  ?>>
                    <?= esc($lembaga['nama']) ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!-- Kode -->
                <div class="form-group m-form__group">
                    <label for="kode">Kode</label>
                    <input type="text" name="kode" id="kode" maxlength="255" required placeholder="Masukkan Kode"
                        value="<?= old('kode') ?? ($isEdit ? $edit['kode'] : '') ?>" class="form-control m-input">
                </div>

                <!-- Nama -->
                <div class="form-group m-form__group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" maxlength="255" required placeholder="Masukkan Nama"
                        value="<?= old('nama') ?? ($isEdit ? $edit['nama'] : '') ?>" class="form-control m-input">
                </div>

                <!-- Form Actions -->
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <a href="<?= site_url('akreditasi/kriteria') ?>" class="btn btn-danger me-2">
                            <i class="fa fa-arrow-left"></i> Batal
                        </a>
                        <button type="reset" class="btn btn-warning me-2">
                            <i class="fa fa-paint-brush"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> <?= $isEdit ? 'Perbarui' : 'Simpan' ?>
                        </button>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success mt-3">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger mt-3">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>