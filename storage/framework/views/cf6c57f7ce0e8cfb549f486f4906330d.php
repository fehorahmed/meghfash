
<?php if(Session::has('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success</strong> <?php echo e(Session::get('success')); ?>.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>


<?php if(session('error')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Oops!</strong> <?php echo e(Session::get('error')); ?>.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if(session('info')): ?>
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <strong>Info!</strong> <?php echo e(Session::get('info')); ?>.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if(session('errors')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Oops!</strong> Need to Validation.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome//alerts.blade.php ENDPATH**/ ?>