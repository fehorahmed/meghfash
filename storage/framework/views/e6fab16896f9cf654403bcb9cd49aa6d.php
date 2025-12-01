 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Brands List')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Brands List</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Brands List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['brands']['add'])): ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.brandsAction',['create'])); ?>">Add Brand</a>
            <?php endif; ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.brands')); ?>">
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
                style="background:#009688;padding: 15px 20px; cursor: pointer;"
            >
               <i class="fa fa-filter"></i> Search click Here..
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.brands')); ?>">
                        <div class="row">
                            <div class="col-md-12 mb-0">
                                <div class="input-group">
                                    <input type="text" name="search" value="<?php echo e(request()->search?request()->search:''); ?>" placeholder="Brand Name" class="form-control <?php echo e($errors->has('search')?'error':''); ?>" />
                                    <button type="submit" class="btn btn-success btn-sm rounded-0"> <i class="fa fa-search"></i> Search</button>
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
        <h4 class="card-title">Brands List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="<?php echo e(route('admin.brands')); ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-1">
                            <select class="form-control form-control-sm rounded-0" name="action" required="">
                                <option value="">Select Action</option>
                                <option value="1">Active</option>
                                <option value="2">InActive</option>
                                <option value="3">Featured</option>
                                <option value="4">Un-Featured</option>
                                <option value="5">Delete</option>
                            </select>
                            <button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <ul class="statuslist">
                            <li><a href="<?php echo e(route('admin.brands')); ?>">All (<?php echo e($totals->total); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.brands',['status'=>'active'])); ?>">Active (<?php echo e($totals->active); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.brands',['status'=>'inactive'])); ?>">Inactive (<?php echo e($totals->inactive); ?>)</a></li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="min-width: 60px;width: 60px;">
                                    <label style="cursor: pointer; margin-bottom: 0;"> <input class="checkbox" type="checkbox" class="form-control" id="checkall" /> All <span class="checkCounter"></span> </label>
                                </th>
                                <th style="min-width: 300px;">Brand Name</th>
                                <th style="max-width: 100px;">Image</th>
                                <th style="min-width: 160px;width: 160px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input class="checkbox" type="checkbox" name="checkid[]" value="<?php echo e($brand->id); ?>" /><br />
                                    <?php echo e($brands->currentpage()==1?$i+1:$i+($brands->perpage()*($brands->currentpage() - 1))+1); ?>

                                </td>
                                <td>
                                    <span><?php echo e($brand->name); ?></span><br />

                                    <?php if($brand->status=='active'): ?>
                                    <span class="badge badge-success">Active </span>
                                    <?php elseif($brand->status=='inactive'): ?>
                                    <span class="badge badge-danger">Inactive </span>
                                    <?php else: ?>
                                    <span class="badge badge-danger">Draft </span>
                                    <?php endif; ?> <?php if($brand->fetured==true): ?>
                                    <span><i class="fa fa-star" style="color: #1ab394;"></i></span>
                                    <?php endif; ?>
                                    <span>
                                        <i class="fa fa-user" style="color: #1ab394;"></i>
                                        <?php echo e($brand->user?$brand->user->name:'No Author'); ?>

                                    </span>
                                    <span>
                                        <i class="fa fa-calendar" style="color: #1ab394;"></i>
                                        <?php echo e($brand->created_at->format('d-m-Y')); ?>

                                    </span>
                                </td>
                                <td style="padding: 5px; text-align: center;">
                                    <img src="<?php echo e(asset($brand->image())); ?>" style="max-width: 80px; max-height: 50px;" />
                                </td>
                                <td class="center">
                                    <a href="<?php echo e(route('admin.brandsAction',['edit',$brand->id])); ?>" class="btn btn-md btn-info">Edit</a>

                                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['brands']['delete'])): ?>
                                    <a href="<?php echo e(route('admin.brandsAction',['delete',$brand->id])); ?>" class="btn btn-md btn-danger" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php echo e($brands->links('pagination')); ?>

                </div>
            </form>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/brands/brandsAll.blade.php ENDPATH**/ ?>