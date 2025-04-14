<?php if (session()->getFlashdata('success')): ?>
  <div class="m-alert m-alert--icon m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
    <div class="m-alert__icon">
      <i class="la la-warning"></i>
    </div>
    <div class="m-alert__text">
      <strong>SUCCESS!</strong> <?= session()->getFlashdata('success'); ?>
    </div>
    <div class="m-alert__close">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      </button>
    </div>
  </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
  <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-danger alert-dismissible fade show"
    role="alert">
    <div class="m-alert__icon">
      <i class="flaticon-exclamation-1"></i>
      <span></span>
    </div>
    <div class="m-alert__text">
      <strong>ERROR!</strong> <?= session()->getFlashdata('error'); ?>
    </div>
    <div class="m-alert__close">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      </button>
    </div>
  </div>
<?php endif; ?>
<script>
  setTimeout(function () {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
      alert.classList.remove('show');
      alert.classList.add('fade');
      setTimeout(() => alert.remove(), 500);
    });
  }, 2000);
</script>