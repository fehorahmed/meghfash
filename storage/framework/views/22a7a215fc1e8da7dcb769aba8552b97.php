 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Dashboard')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startSection('SEO'); ?>
<meta name="title" property="og:title" content="<?php echo e(websiteTitle('Dashboard')); ?>" />
<meta name="description" property="og:description" content="<?php echo general()->meta_description; ?>" />
<meta name="keywords" content="<?php echo e(general()->meta_keyword); ?>" />
<meta name="image" property="og:image" content="<?php echo e(asset(general()->logo())); ?>" />
<meta name="url" property="og:url" content="<?php echo e(route('customer.dashboard')); ?>" />
<link rel="canonical" href="<?php echo e(route('customer.dashboard')); ?>" />
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?> <?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="section customInvoice">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <?php echo $__env->make(welcomeTheme().'.customer.includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="dashboard_content">
                    <div class="card">
                        <div class="card-header">
                            <h3>Dashboard</h3>
                        </div>
                        <div class="card-body">
                            <?php echo $__env->make(welcomeTheme().'.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php if(Auth::user()->admin): ?>
                            <p>
                                Go To <b> <a href="<?php echo e(route('admin.dashboard')); ?>">Admin Dashboard</a></b>
                            </p>
                            <?php endif; ?>
                            <p>
                                From your account dashboard. you can easily check view your <b><a href="<?php echo e(route('customer.profile')); ?>">edit your password and account details.</a></b>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>

<?php echo $__env->make(welcomeTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome/customer/dashboard.blade.php ENDPATH**/ ?>