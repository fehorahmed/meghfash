
<?php if(Session::has('success')): ?>
<div class="alert alert-success alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <strong>Success! </strong> <?php echo e(Session::get('success')); ?>.
</div>
<?php endif; ?>


<?php if(session('error')): ?>
<div class="alert alert-danger alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <strong>Oops! </strong> <?php echo e(Session::get('error')); ?>.
</div>
<?php endif; ?>

<?php if(session('info')): ?>
<div class="alert alert-info alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <strong>Info! </strong> <?php echo e(Session::get('info')); ?>.
</div>
<?php endif; ?>

<?php if(session('errors')): ?>
<div class="alert alert-danger alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <strong>Oops! </strong> Need to Validation.
</div>
<?php endif; ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/alerts.blade.php ENDPATH**/ ?>