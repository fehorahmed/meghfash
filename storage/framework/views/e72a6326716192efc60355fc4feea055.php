 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Post Tags')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Tags List</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Tags List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">

            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.postsTagsAction','create')); ?>">Add Tag</a>
            
            <a class="btn btn-outline-primary reloadPage1" href="<?php echo e(route('admin.postsTags')); ?>">
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
                  <i class="fa fa-filter"></i>  Search click Here..
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="border: 1px solid #00b5b8; border-top: 0;">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.postsTags')); ?>">
                            <div class="row">
                                <div class="col-md-12 mb-0">
                                    <div class="input-group">
                                        <input type="text" name="search" value="<?php echo e(request()->search?request()->search:''); ?>" placeholder="Tag Name" class="form-control <?php echo e($errors->has('search')?'error':''); ?>" />
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
        <h4 class="card-title">Tags List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="<?php echo e(route('admin.postsTags')); ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-1">
                            <select class="form-control form-control-sm rounded-0" name="action" required="">
                                <option value="">Select Action</option>
                                <option value="1">Active</option>
                                <option value="2">InActive</option>
                                <option value="3">Featured</option>
                                <option value="4">Un-featured</option>
                                <option value="5">Deleted</option>
                            </select>
                            <button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="min-width: 60px;width: 100px;">
                                    <label style="cursor: pointer; margin-bottom: 0;"> <input class="checkbox" type="checkbox" class="form-control" id="checkall" /> All <span class="checkCounter"></span> </label>
                                </th>
                                <th style="min-width: 250px;">Tags Name</th>
                                <th style="min-width: 200px;width: 200px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input class="checkbox" type="checkbox" name="checkid[]" value="<?php echo e($tag->id); ?>" />
                                    <br />
                                    <?php echo e($i+1); ?>

                                </td>
                                <td>
                                    <span> <a href="" target="_blank"><?php echo e($tag->name); ?></a></span><br />
                                    <?php if($tag->status=='active'): ?>
                                    <span><i class="fa fa-check" style="color: #1ab394;"></i></span>
                                    <?php else: ?>
                                    <span><i class="fa fa-times" style="color: #ed5565;"></i></span>
                                    <?php endif; ?> <?php if($tag->fetured==true): ?>
                                    <span><i class="fa fa-star" style="color: #1ab394;"></i></span>
                                    <?php endif; ?>
                                    <span style="font-size: 10px;">
                                        <i class="fa fa-user" style="color: #1ab394;"></i>
                                        <?php echo e($tag->user?$tag->user->name:'No Author'); ?>

                                    </span>
                                    <span style="font-size: 10px;"><i class="fa fa-calendar" style="color: #1ab394;"></i> <?php echo e($tag->created_at->format('d-m-Y')); ?></span>
                                </td>
                                <td class="center">
                                    <a href="<?php echo e(route('admin.postsTagsAction',['edit',$tag->id])); ?>" class="btn btn-md btn-info">Edit</a>
                                    <a href="<?php echo e(route('admin.postsTagsAction',['delete',$tag->id])); ?>" onclick="return confirm('Are You Want To Delete?')" class="btn btn-md btn-danger" ><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php echo e($tags->links('pagination')); ?>

                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/posts/tags/postsTags.blade.php ENDPATH**/ ?>