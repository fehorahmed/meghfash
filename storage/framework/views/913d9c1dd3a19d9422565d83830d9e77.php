 
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Items Update')); ?></title>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<style type="text/css">
    .listmenu ul {
        margin: 0;
        padding: 0;
    }
    .listmenu ul li {
        list-style: none;
        margin: 5px;
        padding: 10px;
        border: 1px solid gray;
    }
    .menumanage {
        float: right;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Items Update</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Items Update</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <?php if($item->parent_id): ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.menusAction',['edit',$item->parent_id])); ?>">BACK</a>
            <?php else: ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.menus')); ?>">BACK</a>
            <?php endif; ?>
            <a class="btn btn-outline-primary reloadPage" href="javascript:void(0)">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Items Update</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.menusItemsAction',['update',$item->id])); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?> <?php if($item->menu_type==1): ?>
                                <h4><b> Name:</b> <?php echo e($item->menuName()?:'No Found'); ?> <span style="color: #d8d8d8;">(Page)</span></h4>
                                <?php elseif($item->menu_type==2): ?>
                                <h4><b> Name:</b> <?php echo e($item->menuName()?:'No Found'); ?> <span style="color: #d8d8d8;">(Post Category)</span></h4>
                                <?php elseif($item->menu_type==3): ?>
                                <h4><b> Name:</b> <?php echo e($item->menuName()?:'No Found'); ?> <span style="color: #d8d8d8;">(Product Category)</span></h4>
                                <?php else: ?>
                                <div class="form-group">
                                    <label>Menu Name*</label>
                                    <?php if($errors->has('name')): ?>
                                    <p style="color: red; margin: 0;"><?php echo e($errors->first('name')); ?></p>
                                    <?php endif; ?>
                                    <input type="text" name="name" value="<?php echo e($item->name); ?>" class="form-control" placeholder="Enter Menu Name" />
                                </div>
                                <div class="form-group">
                                    <label>Menu Link</label>
                                    <?php if($errors->has('link')): ?>
                                    <p style="color: red; margin: 0;"><?php echo e($errors->first('link')); ?></p>
                                    <?php endif; ?>
                                    <input type="text" name="link" value="<?php echo e($item->slug); ?>" placeholder="Enter Menu Link" class="form-control" />
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label>Menu Icon (Font Icon class)</label>
                                    <?php if($errors->has('icon')): ?>
                                    <p style="color: red; margin: 0;"><?php echo e($errors->first('icon')); ?></p>
                                    <?php endif; ?>
                                    <input type="text" name="icon" value="<?php echo e($item->icon); ?>" placeholder="Enter Font Icon" class="form-control" />
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-8">
                                        <label>Menu Image (1X1)</label>
                                        <?php if($errors->has('image')): ?>
                                        <p style="color: red; margin: 0;"><?php echo e($errors->first('image')); ?></p>
                                        <?php endif; ?>
                                        <input type="file" name="image" class="form-control" />
                                    </div>
                                    <div class="form-group col-lg-4" style="position: relative;">
                                        <?php if($item->imageFile): ?>
                                        
                                        <?php if(isset(json_decode(Auth::user()->permission->permission, true)['menus']['add'])): ?>
                                        <span style="position: absolute; right: 10px; top: 0px;">
                                            <a href="<?php echo e(route('admin.mediesDelete',$item->imageFile->id)); ?>" class="mediaDelete" style="font-size: 25px; color: red;"><i class="fa fa-times-circle"></i></a>
                                        </span>
                                        <?php endif; ?>

                                        <img src="<?php echo e(asset($item->image())); ?>" style="max-width: 50px;" />
                                        <?php else: ?>
                                        <span>No Image</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label>Target New Window</label>
                                        <div class="i-checks">
                                            <label style="cursor: pointer;"> <input name="target" <?php echo e($item->target?'checked':''); ?> type="checkbox" > <i></i> Active</label>
                                        </div>
                                    </div>
                                </div>
                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['menus']['add'])): ?>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md rounded-0 btn-success">Submit</button>
                                </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Inputs end -->
</div>

<?php $__env->stopSection(); ?> 
<?php $__env->startPush('js'); ?> 
<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/menus/menuItemEdit.blade.php ENDPATH**/ ?>