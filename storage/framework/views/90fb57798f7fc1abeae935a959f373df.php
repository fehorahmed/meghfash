 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Menus List')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Menus List</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Menus List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        	<?php if(isset(json_decode(Auth::user()->permission->permission, true)['menus']['add'])): ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.menusAction',['create'])); ?>">Add Menu</a>
           	<?php endif; ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.menus')); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
        <div class="row">
            <div class="col-md-12">
                <?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Menus List</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 60px;">S:L</th>
                                            <th style="min-width: 300px;">Menu Name</th>
                                            <th style="max-width: 100px;">Location</th>
                                            <th style="max-width: 100px;">Items</th>
                                            <th style="min-width: 200px;width: 200px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <?php echo e($i+1); ?>

                                            </td>
                                            <td>
                                                <span><?php echo e($menu->name); ?></span><br />
                                                <?php if($menu->status=='active'): ?>
                                                <span><i class="fa fa-check" style="color: #1ab394;"></i></span>
                                                <?php else: ?>
                                                <span><i class="fa fa-times" style="color: #ed5565;"></i></span>
                                                <?php endif; ?> <?php if($menu->fetured==true): ?>
                                                <span><i class="fa fa-star" style="color: #1ab394;"></i></span>
                                                <?php endif; ?>
                                                <span style="font-size: 10px;">
                                                    <i class="fa fa-user" style="color: #1ab394;"></i>
                                                    <?php echo e($menu->user?$menu->user->name:'No Author'); ?>

                                                </span>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php echo e(ucfirst($menu->location)); ?>

                                            </td>
                                            <td style="text-align: center;">
                                                <?php echo e($menu->MenuItems->count()); ?>

                                            </td>
                                            <td class="center">
                                                <a href="<?php echo e(route('admin.menusAction',['edit',$menu->id])); ?>" class="btn btn-md btn-info">Config</a>

                                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['menus']['delete'])): ?>
                                                <a href="<?php echo e(route('admin.menusAction',['delete',$menu->id])); ?>" onclick="return confirm('Are You Want To Delete?')" class="btn btn-md btn-danger" ><i class="fa fa-trash"></i></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <?php echo e($menus->links('pagination')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Basic Inputs end -->
</div>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/resources/views/admin/menus/menusAll.blade.php ENDPATH**/ ?>