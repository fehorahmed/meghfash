 <?php $__env->startSection('title'); ?>
<title> <?php echo e(websiteTitle('User Roles')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">User Roles</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">User Roles</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['adminRoles']['add'])): ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.userRoleAction','create')); ?>">
                Add Role
            </a>
            <?php endif; ?>

            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.userRoles')); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


<?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card">
    <div class="card-content">
        <div id="accordion">
            <div
                class="card-header collapsed"
                data-toggle="collapse"
                data-target="#collapseTwo"
                aria-expanded="false"
                aria-controls="collapseTwo"
                id="headingTwo"
                style="cursor: pointer;padding: 15px 20px;background:#009688;"
            >
              <i class="fa fa-filter"></i> Search click Here..
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.userRoles')); ?>">
                        <div class="row">
                            <div class="col-md-12 mb-1">
                                <div class="input-group">
                                    <input type="text" name="search" value="<?php echo e(request()->search?request()->search:''); ?>" placeholder="Search Role Name.." class="form-control <?php echo e($errors->has('search')?'error':''); ?>" />
                                    <button type="submit" class="btn btn-success btn-sm rounded-0"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Roles All List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="min-width: 60px; width: 60px;">SL</th>
                            <th style="min-width: 250px; width: 250px;">Name</th>
                            <th style="min-width: 250px;">Users</th>
                            <th style="min-width: 180px; width: 180px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($i+1); ?></td>
                            <td><?php echo e($role->name); ?></td>
                            <td>Users (<?php echo e($role->users->count()); ?>)</td>
                            <td>
                                <?php if($role->id==1): ?>
                                <a href="<?php echo e(route('admin.userRoleAction',['edit',$role->id])); ?>" class="btn btn-md btn-info">
                                    <i class="fa fa-eye"></i> View
                                </a>
                                <?php else: ?>
                                <a href="<?php echo e(route('admin.userRoleAction',['edit',$role->id])); ?>" class="btn btn-md btn-info">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['adminRoles']['delete'])): ?>
                                <a href="<?php echo e(route('admin.userRoleAction',['delete',$role->id])); ?>" onclick="return confirm('Are You Want To Delete')" class="btn btn-md btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <?php endif; ?> <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php echo e($roles->links('pagination')); ?>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/users/roles/userRoles.blade.php ENDPATH**/ ?>