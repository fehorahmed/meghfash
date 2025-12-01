
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Tag Edit')); ?></title>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style type="text/css">

</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Tag Edit</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Tag Edit</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsTags')); ?>">BACK</a>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.productsTagsAction','create')); ?>">Add Tag</a>
            <a class="btn btn-outline-primary reloadPage" href="javascript:void(0)">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <?php echo $__env->make('admin.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <form action="<?php echo e(route('admin.productsTagsAction',['update',$tag->id])); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Tag Edit</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Tag Name(*) </label>
                                    <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Tag Name" value="<?php echo e($tag->name?:old('name')); ?>" required="" />
                                    <?php if($errors->has('name')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description </label>
                                    <textarea name="description" class="form-control <?php echo e($errors->has('description')?'error':''); ?>" placeholder="Write Description"><?php echo $tag->description; ?></textarea>
                                    <?php if($errors->has('description')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('description')); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Tag Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" <?php echo e($tag->status=='active'?'checked':''); ?>/>
                                        <label class="custom-control-label" for="status">Active</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </section>
    <!-- Basic Inputs end -->
</div>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?>



<?php $__env->stopPush(); ?>

<?php echo $__env->make(general()->adminTheme.'.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/products/tags/tagEdit.blade.php ENDPATH**/ ?>