<div class="row">
  <div class="col-md-12">
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <span class="m-portlet__head-icon m--hide">
              <i class="la la-gear"></i>
            </span>
            <h3 class="m-portlet__head-text">
              Edit Profile
            </h3>
          </div>
        </div>
      </div>
      <?php
      $default_avatar = base_url() . '/public/assets/app/media/img/users/user1.jpg';
      ?>
      <form class="m-form m-form--fit m-form--label-align-right" action="/pemutu/public/profile/edit" method="post"
        enctype="multipart/form-data">
        <div class="m-portlet__body">
          <div class="form-group m-form__group">
            <div class="m-card-user m-card-user--skin-dark w-full">
              <div class="m-card-user__pic">
                <?php if (isset($errors['foto'])): ?>
                  <small class="text-danger"><?= esc($errors['foto']) ?></small>
                <?php endif; ?>
                <input type="file" name="foto" accept="image/jpeg, image/png" />
                <?php
                $user = new App\Models\UserModel();
                if ($user->getAvatar()): ?>
                  <img id="profileImagePreview" src="<?= $user->getAvatar(); ?>" class="m--img-rounded m--marginless"
                    alt="user-profile" />
                <?php else: ?>
                  <img id="profileImagePreview" src="<?= $default_avatar ?>" class="m--img-rounded m--marginless"
                    alt="user-profile" />
                <?php endif; ?>
                <script>
                  document.querySelector('input[name="foto"]').addEventListener('change', function (event) {
                    const file = event.target.files[0];
                    if (file) {
                      const reader = new FileReader();
                      reader.onload = function (e) {
                        document.getElementById('profileImagePreview').src = e.target.result;
                      };
                      reader.readAsDataURL(file);
                    }
                  });
                </script>
              </div>
              <p class="form-control-static">
                <?= session()->get('username'); ?>
              </p>
              <label for="exampleInputEmail1">
                Nama (Optional)
              </label>
              <input type="text" class="form-control m-input" id="exampleInputEmail1" aria-describedby="emailHelp"
                placeholder="Nama" name="nama" value="<?= esc($old['nama'] ?? $user->getDisplayName()) ?>">
              <span class="m-form__help">
                Masukkan nama untuk ditampilkan pada halaman.
              </span>
              <?php if (isset($errors['nama'])): ?>
                <small class="text-danger"><?= esc($errors['nama']) ?></small>
              <?php endif; ?>
            </div>
          </div>
          <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
              <input type="submit" class="btn btn-primary" value="Simpan" />
            </div>
          </div>
        </div>
      </form>

    </div>
    <div class="m-portlet m-portlet--tab">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title">
            <span class="m-portlet__head-icon m--hide">
              <i class="la la-gear"></i>
            </span>
            <h3 class="m-portlet__head-text">
              Reset Password
            </h3>
          </div>
        </div>
      </div>
      <form class="m-form m-form--fit m-form--label-align-right">
        <div class="m-portlet__body">
          <div class="form-group m-form__group">
            <label for="exampleInputPassword1">
              Password
            </label>
            <input type="password" class="form-control m-input" id="exampleInputPassword1" placeholder="Password">
          </div>
          <div class="form-group m-form__group">
            <label for="exampleInputPassword1">
              Konfirmasi Password
            </label>
            <input type="password" class="form-control m-input" id="exampleInputKonfirmasiPassword1"
              placeholder="Konfirmasi password">
          </div>
          <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
              <button type="reset" class="btn btn-danger">
                Reset password
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!--end::Portlet-->
  </div>
</div>