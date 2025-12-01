 
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Customer Users')); ?></title>
<?php $__env->stopSection(); ?> 
<?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> 
<?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Customer Users</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Customer Users</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['users']['add'])): ?>
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#AddUser">Add User</button>
            <?php endif; ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.usersCustomer')); ?>">
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
                    <form action="<?php echo e(route('admin.usersCustomer')); ?>">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <div class="input-group">
                                    <input type="date" name="startDate" value="<?php echo e(request()->startDate?:''); ?>" class="form-control <?php echo e($errors->has('startDate')?'error':''); ?>" />
                                    <input type="date" value="<?php echo e(request()->endDate?:''); ?>" name="endDate" class="form-control <?php echo e($errors->has('endDate')?'error':''); ?>" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <div class="input-group">
                                    <input type="text" name="search" value="<?php echo e(request()->search?:''); ?>" placeholder="User Name, Email, Mobile, M/C ID" class="form-control <?php echo e($errors->has('search')?'error':''); ?>" />
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
        <h4 class="card-title">Customer users List</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
        <form action="<?php echo e(route('admin.usersCustomer')); ?>">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group mb-1">
                        <select class="form-control form-control-sm rounded-0" name="action" required="">
                            <option value="">Select Action</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                            <option value="5">Delete</option>
                        </select>
                        <button class="btn btn-sm btn-primary rounded-0" onclick="return confirm('Are You Want To Action?')">Action</button>
                    </div>
                </div>
                <div class="col-md-4">
                    
                </div>
                <div class="col-md-4">
                    <ul class="statuslist">
                        <li><a href="<?php echo e(route('admin.usersCustomer')); ?>">All (<?php echo e($totals->total); ?>)</a></li>
                        <li><a href="<?php echo e(route('admin.usersCustomer',['status'=>'active'])); ?>">Active (<?php echo e($totals->active); ?>)</a></li>
                        <li><a href="<?php echo e(route('admin.usersCustomer',['status'=>'inactive'])); ?>">Inactive (<?php echo e($totals->inactive); ?>)</a></li>
                    </ul>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="min-width: 60px; width: 60px;">
                                <label style="cursor: pointer; margin-bottom: 0;"> <input class="checkbox" type="checkbox" class="form-control" id="checkall" /> All <span class="checkCounter"></span> </label>
                            </th>
                            <th style="min-width: 100px; width: 100px;">Image</th>
                            <th style="min-width: 200px; width: 200px;">Name</th>
                            <th style="min-width: 150px;">Mobile/Email</th>
                            <th style="min-width: 80px;">Status</th>
                            <th style="min-width: 80px;">Join Date</th>
                            <th style="min-width: 150px; width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if($user->id==Auth::id()): ?> <?php else: ?>
                                <input class="checkbox" type="checkbox" name="checkid[]" value="<?php echo e($user->id); ?>" />
                                <?php endif; ?>
                                <?php echo e($users->currentpage()==1?$i+1:$i+($users->perpage()*($users->currentpage() - 1))+1); ?>

                            </td>
                            <td style="padding: 0 3px; text-align: center;">
                                <span>
                                    <img src="<?php echo e(asset($user->image())); ?>" style="max-width: 60px; max-height: 50px;" />
                                </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.usersCustomerAction',['view',$user->id])); ?>" class="invoice-action-view mr-1"><?php echo e($user->name); ?></a>
                                <?php if($user->member_card_id): ?>
                                <small style="color: #ff864a;font-weight: bold;"><br><b>M/C:</b> <?php echo e($user->member_card_id); ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($user->mobile?:$user->email); ?></td>
                            <td>
                                <?php if($user->status): ?>
                                <span class="badge badge-success">Active </span>
                                <?php else: ?>
                                <span class="badge badge-danger">Inactive </span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($user->created_at->format('d M Y')); ?></td>
                            <td style="padding:0; text-align: center;">
                                <a href="<?php echo e(route('admin.usersCustomerAction',['edit',$user->id])); ?>" class="btn btn-md btn-info">
                                    <i class="fa fa-edit"></i> Edit
                                </a>

                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['users']['delete'])): ?>
                                
                                <?php if($user->id==Auth::id() || $user->id=='621'): ?> <?php else: ?>
                                <a href="<?php echo e(route('admin.usersCustomerAction',['delete',$user->id])); ?>" onclick="return confirm('Are You Want To Delete')" class="btn btn-md btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <?php endif; ?> 
                                
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php echo e($users->links('pagination')); ?>


        </form>
        </div>
    </div>
</div>


<?php if(isset(json_decode(Auth::user()->permission->permission, true)['users']['add'])): ?>
 <!-- Modal -->
 <div class="modal fade text-left" id="AddUser" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
	 <div class="modal-content">
	 	<form action="<?php echo e(route('admin.usersCustomerAction','create')); ?>" method="post">
	   		<?php echo csrf_field(); ?>
	   <div class="modal-header">
		 <h4 class="modal-title">Add User</h4>
		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		   <span aria-hidden="true">&times; </span>
		 </button>
	   </div>
	   <div class="modal-body">
	   		<div class="form-group">
			    <label for="name">Name* </label>
                <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Name" required="">
				<?php if($errors->has('name')): ?>
				<p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
				<?php endif; ?>
         	</div>
			 <div class="form-group">
				<label for="name">Mobile/Email* </label>
				<input type="mobile_email" class="form-control <?php echo e($errors->has('mobile_email')?'error':''); ?>" name="mobile_email" placeholder="Enter Mobile/Email" required="">
				<?php if($errors->has('mobile_email')): ?>
				<p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('mobile_email')); ?></p>
				<?php endif; ?>
         	</div>
	   </div>
	   <div class="modal-footer">
		 <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close </button>
		 <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add User</button>
	   </div>
	   </form>
	 </div>
   </div>
 </div>
<?php endif; ?>



<?php $__env->stopSection(); ?> 
<?php $__env->startPush('js'); ?> 
<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/users/customers/users.blade.php ENDPATH**/ ?>