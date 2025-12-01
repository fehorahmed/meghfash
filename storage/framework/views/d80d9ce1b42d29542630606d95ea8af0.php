 
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Posts List')); ?></title>
<?php $__env->stopSection(); ?> 

<?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> 

<?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Posts List</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Posts List</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['posts']['add'])): ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.postsAction',['create'])); ?>">Add Post</a>
            <?php endif; ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.posts')); ?>">
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
                        <form action="<?php echo e(route('admin.posts')); ?>">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <div class="input-group">
                                        <input type="date" name="startDate" value="<?php echo e(request()->startDate?Carbon\Carbon::parse(request()->startDate)->format('Y-m-d') :''); ?>" class="form-control <?php echo e($errors->has('startDate')?'error':''); ?>" />
                                        <input type="date" value="<?php echo e(request()->endDate?Carbon\Carbon::parse(request()->endDate)->format('Y-m-d') :''); ?>" name="endDate" class="form-control <?php echo e($errors->has('endDate')?'error':''); ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <div class="input-group">
                                        <input type="text" name="search" value="<?php echo e(request()->search?request()->search:''); ?>" placeholder="Post Name, Category Name" class="form-control <?php echo e($errors->has('search')?'error':''); ?>" />
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
        <h4 class="card-title">Posts List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <form action="<?php echo e(route('admin.posts')); ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-1">
                            <select class="form-control form-control-sm rounded-0" name="action" required="">
                                <option value="">Select Action</option>
                                <option value="1">Active</option>
                                <option value="2">InActive</option>
                                <option value="3">Feature</option>
                                <option value="4">Un-feature</option>
                                <option value="5">Delete</option>
                            </select>
                            <button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <ul class="statuslist">
                            <li><a href="<?php echo e(route('admin.posts')); ?>">All (<?php echo e($totals->total); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.posts',['status'=>'active'])); ?>">Active (<?php echo e($totals->active); ?>)</a></li>
                            <li><a href="<?php echo e(route('admin.posts',['status'=>'inactive'])); ?>">Inactive (<?php echo e($totals->inactive); ?>)</a></li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="min-width: 60px;">
                                    <label style="cursor: pointer; margin-bottom: 0;"> <input class="checkbox" type="checkbox" class="form-control" id="checkall" /> All <span class="checkCounter"></span> </label>
                                </th>
                                <th style="min-width: 300px;">Post Name</th>
                                <th style="min-width: 100px;">Image</th>
                                <th style="min-width: 200px;">Category</th>
                                <th style="min-width: 100px;">Action/Author</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input class="checkbox" type="checkbox" name="checkid[]" value="<?php echo e($post->id); ?>" /><br />
                                    <?php echo e($posts->currentpage()==1?$i+1:$i+($posts->perpage()*($posts->currentpage() - 1))+1); ?>

                                </td>
                                <td>
                                    <span><a href="<?php echo e(route('blogView',$post->slug?:'no-title')); ?>" target="_blank"><?php echo e($post->name); ?></a></span><br />

                                    <span><i class="fa fa-eye" style="color: #1ab394;"></i> 0</span>
                                    <?php if($post->status=='active'): ?>
                                    <span class="badge badge-success">Active </span>
                                    <?php elseif($post->status=='inactive'): ?>
                                    <span class="badge badge-danger">Inactive </span>
                                    <?php else: ?>
                                    <span class="badge badge-danger">Draft </span>
                                    <?php endif; ?> <?php if($post->fetured==true): ?>
                                    <span><i class="fa fa-star" style="color: #1ab394;"></i></span>
                                    <?php endif; ?>

                                    <span><i class="fa fa-calendar" style="color: #1ab394;"></i> <?php echo e($post->created_at->format('d-m-Y')); ?></span>

                                    <span>
                                        <a href="<?php echo e(route('admin.postsComments',$post->id)); ?>"><i class="fa fa-comment" style="color: #1ab394;"></i> (<?php echo e($post->postComments->where('status','<>','temp')->count()); ?>)</a>
                                    </span>
                                </td>
                                <td style="padding: 5px; text-align: center;">
                                    <img src="<?php echo e(asset($post->image())); ?>" style="max-width: 80px; max-height: 50px;" />
                                </td>
                                <td>
                                    <?php $__currentLoopData = $post->postCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$ctg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($i==0?'':'-'); ?> <?php echo e($ctg->name); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td style="padding: 5px; text-align: center;">
                                    
                                    <a href="<?php echo e(route('admin.postsAction',['edit',$post->id])); ?>" class="btn btn-sm btn-info">Edit</a>

                                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['posts']['delete'])): ?>
                                    <a href="<?php echo e(route('admin.postsAction',['delete',$post->id])); ?>" onclick="return confirm('Are You Want To Delete?')" class="btn btn-sm btn-danger" ><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
                                    <br />
                                    <span>
                                        <i class="fa fa-user" style="color: #1ab394;"></i>
                                        <?php echo e(Str::limit($post->user?$post->user->name:'No Author',15)); ?>

                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <?php echo e($posts->links('pagination')); ?>

                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?>
<script type="text/javascript">
    
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/resources/views/admin/posts/postsAll.blade.php ENDPATH**/ ?>