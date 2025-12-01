<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Page Not Found')); ?></title>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style type="text/css">
    .errorPage {
        text-align: center;
        padding: 20% 0;
    }
    .errorPage h1{
        font-size: 120px;
        color: #f1594c;
    }
    .btn-Success {
        background: #009688;
        color: white;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="errorPage">
                <h1>404</h1>
                <h2>Oppos!</h2>
                <h5>Page Not Found</h5><br><br>
                <a href="<?php echo e(route('index')); ?>" class="btn btn-Success"><i class="fa fa-home"></i> Return Home</a>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make(welcomeTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\posher-react-laravel\resources\views/errors/404.blade.php ENDPATH**/ ?>