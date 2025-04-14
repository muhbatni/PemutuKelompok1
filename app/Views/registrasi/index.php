<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->

<head>
  <meta charset="utf-8" />
  <title>
    Pemutu
  </title>
  <meta name="description" content="Latest updates and statistic charts">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!--begin::Web font -->
  <script src="<?= base_url(); ?>/public/assets/app/js/webfont.js"></script>
  <script>
    WebFont.load({
      google: { "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"] },
      active: function () {
        sessionStorage.fonts = true;
      }
    });
  </script>
  <!--end::Web font -->
  <!--begin::Base Styles -->
  <link href="<?= base_url(); ?>/public/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url(); ?>/public/assets/app/css/style.bundle.css" rel="stylesheet" type="text/css" />
  <script src="<?= base_url(); ?>/public/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
  <script src="<?= base_url(); ?>/public/assets/app/js/scripts.bundle.js" type="text/javascript"></script>
  <!--end::Base Styles -->
  <link rel="shortcut icon" href="<?= base_url(); ?>/public/assets/demo/default/media/img/logo/favicon.ico" />
</head>
<!-- end::Head -->

<body class="m--skin m-header--fixed m-header--fixed-mobile">
  <?php include APPPATH . 'Views/partials/alerts.php'; ?>
  <!-- begin:: Page -->
  <div class="m-grid m-grid--hor m-grid--root m-page">
    <div
      class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin"
      id="m_login" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
      <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
        <div class="m-stack m-stack--hor m-stack--desktop">
          <div class="m-stack__item m-stack__item--fluid">
            <div class="m-login__wrapper">
              <div class="m-login__logo">
                <a href="#">
                  <img src="./assets/app/media/img/logos/logo-2.png">
                </a>
              </div>
              <div class="m-login__signup">
                <div class="m-login__head">
                  <h3 class="m-login__title">Pendaftaran Akun</h3>
                  <div class="m-login__desc">Masukkan detail Anda untuk membuat akun</div>
                </div>
                <form class="m-login__form m-form" action="registrasi" method="post">
                  <div class="form-group m-form__group">
                    <input class="form-control m-input" type="text" placeholder="Username" name="username">
                  </div>
                  <div class="form-group m-form__group">
                    <input class="form-control m-input" type="password" placeholder="Password" name="password">
                  </div>
                  <div class="form-group m-form__group">
                    <input class="form-control m-input m-login__form-input--last" type="password"
                      placeholder="Konfirmasi Password" autocomplete="off">
                  </div>
                  <select class="form-control m-input" name="tipe">
                    <option value="">Pilih Tipe Akun</option>
                    <option value="1">Dosen</option>
                    <option value="2">Laboran</option>
                    <option value="3">Peserta/Mahasiswa</option>
                  </select>
                  <div class="row form-group m-form__group m-login__form-sub">
                    <div class="col m--align-left">
                      <label class="m-checkbox m-checkbox--focus">
                        <input type="checkbox" name="agree"> Saya menyetujui <a href="#"
                          class="m-link m-link--focus">syarat dan ketentuan</a>.
                        <span></span>
                      </label>
                    </div>
                  </div>
                  <div class="m-login__form-action">
                    <button id="m_login_signup_submit"
                      class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">Daftar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="m-stack__item m-stack__item--center">
            <div class="m-login__account">
              <span class="m-login__account-msg">
                Belum memiliki akun?
              </span>&nbsp;&nbsp;
              <a href="login" id="m_login_signup" class="m-link m-link--focus m-login__account-link">Masuk</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end:: Page -->
</body>

</html>