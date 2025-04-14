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
  <style>
    .m-nav__item {
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
</head>
<!-- end::Head -->
<?php
use App\Controllers\Auth;
?>

<body
  class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
  <!-- begin:: Page -->
  <div class="m-grid m-grid--hor m-grid--root m-page">
    <!-- BEGIN: Header -->
    <header class="m-grid__item    m-header " data-minimize-offset="200" data-minimize-mobile-offset="200">
      <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
          <!-- BEGIN: Logo -->
          <div class="m-stack__item m-brand  m-brand--skin-dark ">
            <div class="m-stack m-stack--ver m-stack--general">
              <div class="m-stack__item m-stack__item--middle m-brand__logo">
                <a href="index.html" class="m-brand__logo-wrapper">
                  <img alt=""
                    src="<?= base_url(); ?>/public/assets/demo/default/media/img/logo/logo_default_dark.png" />
                </a>
              </div>
              <div class="m-stack__item m-stack__item--middle m-brand__tools">
                <!-- BEGIN: Left Aside Minimize Toggle -->
                <a href="javascript:;" id="m_aside_left_minimize_toggle"
                  class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block ">
                  <span></span>
                </a>
                <!-- END -->
                <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                  class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                  <span></span>
                </a>
                <!-- END -->
                <!-- BEGIN: Responsive Header Menu Toggler -->
                <a id="m_aside_header_menu_mobile_toggle" href="javascript:;"
                  class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                  <span></span>
                </a>
                <!-- END -->
                <!-- BEGIN: Topbar Toggler -->
                <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                  class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                  <i class="flaticon-more"></i>
                </a>
                <!-- BEGIN: Topbar Toggler -->
              </div>
            </div>
          </div>
          <!-- END: Logo -->

          <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
            <!-- BEGIN: Horizontal Menu -->
            <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark "
              id="m_aside_header_menu_mobile_close_btn">
              <i class="la la-close"></i>
            </button>
            <div id="m_header_menu"
              class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
              <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" data-menu-submenu-toggle="click"
                  data-redirect="true" aria-haspopup="true">
                  <a href="#" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-add"></i>
                    <span class="m-menu__link-text">
                      Horizontal Menu
                    </span>
                    <i class="m-menu__hor-arrow la la-angle-down"></i>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                  </a>
                  <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                    <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                    <ul class="m-menu__subnav">
                      <li class="m-menu__item " aria-haspopup="true">
                        <a href="header/actions.html" class="m-menu__link ">
                          <i class="m-menu__link-icon flaticon-file"></i>
                          <span class="m-menu__link-text">
                            Create New Horizontal Menu
                          </span>
                        </a>
                      </li>

                    </ul>
                  </div>
                </li>
              </ul>
            </div>
            <!-- END: Horizontal Menu --> <!-- BEGIN: Topbar -->
            <div id="m_header_topbar" class="m-topbar">
              <div class="m-stack__item m-topbar__nav-wrapper">
                <ul class="m-topbar__nav m-nav m-nav--inline">
                  <?php
                  $auth = new Auth();
                  $display_name = $auth->getDisplayName() ?? 'Guest';
                  ?>
                  <li class="m-nav__item">
                    <?php if (session()->get('logged_in')): ?>
                      <span>Welcome, <?= esc($display_name); ?>!</>
                      <?php else: ?>
                        <span>You are not logged in.</span>
                      <?php endif; ?>
                  </li>
                  <li
                    class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                    data-dropdown-toggle="click">
                    <a href="#" class="m-nav__link m-dropdown__toggle">
                      <span class="m-topbar__userpic">
                        <img src="<?= base_url(); ?>/public/assets/app/media/img/users/user4.jpg"
                          class="m--img-rounded m--marginless m--img-centered" alt="" />
                      </span>
                    </a>
                    <div class="m-dropdown__wrapper">
                      <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                      <div class="m-dropdown__inner">
                        <div class="m-dropdown__header m--align-center"
                          style="background: url(); background-size: cover;">
                          <div class="m-dropdown__header m--align-center">
                            <div class="m-card-user m-card-user--skin-dark">
                              <div class="m-card-user__pic">
                                <img src="<?= base_url(); ?>/public/assets/app/media/img/users/user4.jpg"
                                  class="m--img-rounded m--marginless" alt="user-profile" />
                              </div>
                              <div class="m-card-user__details m--flex m--items-end">
                                <span class="m-card-user__name m--font-weight-500">
                                  <?= esc($display_name); ?>
                                </span>
                                <span class="m-card-user__email m--font-weight-300">
                                  <?= match (session()->get('tipe')) {
                                    "1" => "Dosen",
                                    "2" => "Laboran",
                                    "3" => "Mahasiswa",
                                    default => "Undefined",
                                  }; ?>
                                </span>
                              </div>
                            </div>
                          </div>
                          <div class="m-dropdown__body">
                            <div class="m-dropdown__content">
                              <ul class="m-nav m-nav--skin-light">
                                <li class="m-nav__section m--hide">
                                  <span class="m-nav__section-text">
                                    Section
                                  </span>
                                </li>
                                <li class="m-nav__item">
                                  <a href="dashboard" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-profile-1"></i>
                                    <span class="m-nav__link-title">
                                      <span class="m-nav__link-wrap">
                                        <span class="m-nav__link-text">
                                          My Profile
                                        </span>
                                        <span class="m-nav__link-badge">
                                          <!-- <span class="m-badge m-badge--success">
                                          2
                                        </span> -->
                                        </span>
                                      </span>
                                    </span>
                                  </a>
                                </li>
                                <li class="m-nav__separator m-nav__separator--fit"></li>
                                <li class="m-nav__item">
                                  <a href="auth/logout"
                                    class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                    Logout
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                  </li>
                </ul>
              </div>
            </div>
            <!-- END: Topbar -->
          </div>
        </div>
      </div>
    </header>
    <!-- END: Header -->
    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
      <!-- BEGIN: Left Aside -->
      <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
        <i class="la la-close"></i>
      </button>
      <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
        <!-- BEGIN: Aside Menu -->
        <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
          data-menu-vertical="true" data-menu-scrollable="false" data-menu-dropdown-timeout="500">
          <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item  m-menu__item--active" aria-haspopup="true">
              <a href="survey-kepuasan" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
                  <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                      Survey Kepuasan
                    </span>
                    <span class="m-menu__link-badge">
                      <span class="m-badge m-badge--danger">
                        B
                      </span>
                    </span>
                  </span>
                </span>
              </a>
            </li>
            <li class="m-menu__section">
              <h4 class="m-menu__section-text">
                Group Menu
              </h4>
              <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover">
              <a href="#" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-share"></i>
                <span class="m-menu__link-text">
                  Menu
                </span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
              </a>
              <div class="m-menu__submenu">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                  <li class="m-menu__item " aria-haspopup="true">
                    <a href="components/icons/flaticon.html" class="m-menu__link ">
                      <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                        <span></span>
                      </i>
                      <span class="m-menu__link-text">
                        Sub Menu
                      </span>
                    </a>
                  </li>

                </ul>
              </div>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover">
              <a href="#" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-share"></i>
                <span class="m-menu__link-text">
                  Lembaga Akreditasi
                </span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
              </a>
              <div class="m-menu__submenu">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                  <li class="m-menu__item " aria-haspopup="true">
                  <a href="kriteria-akreditasi" class="m-menu__link ">
                      <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                        <span></span>
                      </i>
                      <span class="m-menu__link-text">
                        Kriteria Akreditasi
                      </span>
                    </a>
                    <a href="syarat-unggul" class="m-menu__link ">
                      <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                        <span></span>
                      </i>
                      <span class="m-menu__link-text">
                        Syarat Unggul
                      </span>
                    </a>
                    <a href="instrumen-pemutu" class="m-menu__link ">
                      <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                        <span></span>
                      </i>
                      <span class="m-menu__link-text">
                        Instrumen Pemutu
                      </span>
                    </a>
                    <a href="dokumen-penetapan" class="m-menu__link ">
                      <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                        <span></span>
                      </i>
                      <span class="m-menu__link-text">
                        Dokumen Penetapan
                      </span>
                    </a>
                    <a href="akreditasi" class="m-menu__link ">
                      <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                        <span></span>
                      </i>
                      <span class="m-menu__link-text">
                        Akreditasi
                      </span>
                    </a>
                    <a href="periode" class="m-menu__link ">
                      <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                        <span></span>
                      </i>
                      <span class="m-menu__link-text">
                        Periode
                      </span>
                    </a>
                    <a href="input-datapemutu" class="m-menu__link ">
                      <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                        <span></span>
                      </i>
                      <span class="m-menu__link-text">
                        Input Data Pemutu
                      </span>
                    </a>
                    <a href="dashboard" class="m-menu__link ">
                      <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                        <span></span>
                      </i>
                      <span class="m-menu__link-text">
                        Dashboard Pemutu
                      </span>
                    </a>
                  </li>

                </ul>
              </div>
            </li>
          </ul>
        </div>
        <!-- END: Aside Menu -->
      </div>
      <!-- END: Left Aside -->
      <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <?php include APPPATH . 'Views/partials/alerts.php'; ?>
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
          <div class="d-flex align-items-center">
            <div class="mr-auto">
              <h3 class="m-subheader__title ">
                <?= $title ?>
              </h3>
            </div>
          </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">