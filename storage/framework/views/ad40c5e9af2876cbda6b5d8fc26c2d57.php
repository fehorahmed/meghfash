
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('My WishList')); ?></title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('SEO'); ?>
<meta name="title" property="og:title" content="<?php echo e(websiteTitle('My WishList')); ?>" />
<meta name="description" property="og:description" content="<?php echo general()->meta_description; ?>" />
<meta name="keyword" property="og:keyword" content="<?php echo e(general()->meta_keyword); ?>" />
<meta name="image" property="og:image" content="<?php echo e(asset(general()->logo())); ?>" />
<meta name="url" property="og:url" content="<?php echo e(route('myWishlist')); ?>" />
<link rel="canonical" href="<?php echo e(route('myWishlist')); ?>">
<?php $__env->stopSection(); ?> 
<?php $__env->startPush('css'); ?>

<style>
    .section.wishlistPage {
        background-color: #f9f9f9;
        padding: 40px 0;
    }
    
    .table-responsive.wishlist_table {
        background-color: #fff;
        padding: 20px;
        box-shadow: 0px 0px 10px #ccc;
    }
</style>
<?php $__env->stopPush(); ?> 

<?php $__env->startSection('contents'); ?>
<div class="singleProHead">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('index')); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Wishlist</li>
            </ol>
        </nav>
    </div>
</div>
<!-- START SECTION SHOP -->
<div class="section wishlistPage">
	<div class="container viewItemsLists">
        <?php echo $__env->make(welcomeTheme().'.carts.includes.wishlistItems', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<!-- END SECTION SHOP -->

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>
<?php echo $__env->make(welcomeTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/welcome/carts/myWishlist.blade.php ENDPATH**/ ?>