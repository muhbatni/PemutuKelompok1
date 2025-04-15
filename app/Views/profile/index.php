<?php
$user = new App\Models\UserModel();
$displayName = $user->getDisplayName() ?? 'Guest';
$defaultAvatar = base_url() . '/public/assets/app/media/img/users/300_14.jpg';
$avatar = $user->getAvatar() ?? $defaultAvatar;
?>
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
      <form class="m-form m-form--fit m-form--label-align-right" action="/pemutu/public/profile/edit" method="post"
        enctype="multipart/form-data">
        <div class="m-portlet__body">
          <div class="form-group m-form__group">
            <div class="m-card-user m-card-user--skin-dark w-full">
              <div class="profile">
                <div class="profile-picture-wrapper">
                  <img id="profileImagePreview" src="<?= $avatar ?>" class="profile-picture" alt="user-profile" />
                  <input type="file" name="avatar" accept="image/jpeg, image/png" class="profile-img-input"
                    onchange="getPreviewImage(this)" />
                  <i class="flaticon-edit-1"></i>
                </div>
                <div class="profile-details-wrapper">
                  <?php if (isset($errors['avatar'])): ?>
                    <small class="text-danger"><?= esc($errors['avatar']) ?></small>
                  <?php endif; ?>
                  <?php if (isset($errors['nama'])): ?>
                    <small class="text-danger"><?= esc($errors['nama']) ?></small>
                  <?php endif; ?>
                  <p class="form-control-static">
                    <?= $displayName ?>
                  </p>
                  <label for="exampleInputEmail1">
                    Nama (Optional)
                  </label>
                  <input type="text" class="form-control m-input" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Nama" name="nama" value="<?= esc($old['nama'] ?? $user->getDisplayName()) ?>">
                  <span class="m-form__help">
                    Masukkan nama untuk ditampilkan pada halaman.
                  </span>
                </div>
              </div>
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