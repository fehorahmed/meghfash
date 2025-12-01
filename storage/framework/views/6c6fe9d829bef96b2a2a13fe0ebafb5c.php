
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Supplier Profile')); ?></title>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style type="text/css">
    .showPassword {
    right: 0 !important;
    cursor: pointer;
    }
    .ProfileImage{
        max-width: 64px;
        max-height: 64px;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('contents'); ?>


<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
     <h3 class="content-header-title mb-0">Supplier Profile</h3>
     <div class="row breadcrumbs-top">
       <div class="breadcrumb-wrapper col-12">
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a>
           </li>
           <li class="breadcrumb-item active">Supplier Profile</li>
         </ol>
       </div>
     </div>
    </div>
   <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
     <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
       
       <a class="btn btn-outline-primary" href="<?php echo e(route('admin.usersSupplier')); ?>">
       		Back
       	</a>
       	<a class="btn btn-outline-primary" href="<?php echo e(route('admin.usersSupplierAction',['edit',$user->id])); ?>">
       		<i class="fa-solid fa-rotate"></i>
       	</a>
     </div>
   </div>
</div>
 
	

    <?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title">Supplier Profile</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.usersSupplierAction',['update',$user->id])); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="media">
                                <a href="javascript: void(0);">
                                    <img src="<?php echo e(asset($user->image())); ?>"  class="ProfileImage image_<?php echo e($user->id); ?> rounded mr-75" style="max-height: 100px;" alt="profile image" />
                                </a>
                                <div class="media-body" style="padding: 0 10px;">
                                    <div style="display:flex;">
                                        <label class="btn btn-sm btn-primary cursor-pointer" for="account-upload" >Upload photo </label>
                                        <input type="file" name="image" id="account-upload" class="account-upload" data-imageshow="image_<?php echo e($user->id); ?>" hidden="" />
                                        <?php if($user->imageFile): ?>
                                        <a href="<?php echo e(route('admin.mediesDelete',$user->imageFile->id)); ?>" class="mediaDelete btn btn-sm btn-secondary" style="margin: 0 10px;height:31px;">Reset </a>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($errors->has('image')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image')); ?></p>
                                    <?php endif; ?>
                                    <p class="text-muted"><small>Allowed JPG, GIF or PNG. Max size of 2048kB</small></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xl-4 col-lg-4 col-md-12">
                                    <label for="name">Name* </label>
                                    <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Name" value="<?php echo e($user->name?:old('name')); ?>" required="" />
                                    <?php if($errors->has('name')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-xl-4 col-lg-4 col-md-12">
                                    <label for="mobile">Mobile* </label>
                                    <input type="text" class="form-control <?php echo e($errors->has('mobile')?'error':''); ?>" name="mobile" placeholder="Enter Mobile" value="<?php echo e($user->mobile?:old('mobile')); ?>" required="" />
                                    <?php if($errors->has('mobile')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('mobile')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-xl-4 col-lg-4 col-md-12">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control <?php echo e($errors->has('email')?'error':''); ?>" name="email" placeholder="Enter Email" value="<?php echo e($user->email?:old('email')); ?>" required="" />
                                    <?php if($errors->has('email')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('email')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-xl-4 col-lg-4 col-md-4">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" class="form-control <?php echo e($errors->has('company_name')?'error':''); ?>" name="company_name" placeholder="Enter company name" value="<?php echo e($user->company_name?:old('company_name')); ?>" />
                                    <?php if($errors->has('company_name')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('company_name')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-xl-8 col-lg-8 col-md-8">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control <?php echo e($errors->has('address')?'error':''); ?>" name="address" placeholder="Enter Address" value="<?php echo e($user->address_line1?:old('address')); ?>" />
                                    <?php if($errors->has('address')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('address')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="status">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="status" id="status" <?php echo e($user->status?'checked':''); ?>/>
                                        <label class="custom-control-label" for="status">User Active</label>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="created_at">Created Date</label>
                                    <input type="date" name="created_at" value="<?php echo e($user->created_at?$user->created_at->format('Y-m-d'):old('created_at')); ?>" class="form-control <?php echo e($errors->has('created_at')?'error':''); ?>">
                                    <?php if($errors->has('created_at')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('created_at')); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>                        
                            <button type="submit" class="btn btn-primary btn-md rounded-0">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="col-md-5">-->
        <!--    <div class="card">-->
        <!--        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">-->
        <!--            <h4 class="card-title">Change Password</h4>-->
        <!--        </div>-->
        <!--        <div class="card-content">-->
        <!--            <div class="card-body">-->
        <!--                <form action="<?php echo e(route('admin.usersCustomerAction',['change-password',$user->id])); ?>" method="post">-->
        <!--                    <?php echo csrf_field(); ?>-->
        <!--                    <div class="row">-->
        <!--                        <div class="col-xl-12 col-lg-12 col-md-12 form-group">-->
        <!--                            <label for="old_password">Old password </label>-->
        <!--                            <div class="input-group">-->
        <!--                                <input type="password" class="form-control password" placeholder="Old Password" name="old_password" value="<?php echo e($user->password_show?:old('old_password')); ?>" required="" />-->
        <!--                                <div class="input-group-append">-->
        <!--                                    <span class="input-group-text showPassword"><i class="fa fa-eye-slash"></i></span>-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                            <?php if($errors->has('old_password')): ?>-->
        <!--                            <p style="color: red; margin: 0;"><?php echo e($errors->first('old_password')); ?></p>-->
        <!--                            <?php endif; ?>-->
        <!--                        </div>-->
        <!--                        <div class="col-xl-12 col-lg-12 col-md-12 form-group">-->
        <!--                            <label for="password">New Password </label>-->
        <!--                            <input type="password" class="form-control password <?php echo e($errors->has('password')?'error':''); ?>" name="password" placeholder="New password" required="" />-->
        <!--                            <?php if($errors->has('password')): ?>-->
        <!--                            <p style="color: red; margin: 0;"><?php echo e($errors->first('password')); ?></p>-->
        <!--                            <?php endif; ?>-->
        <!--                        </div>-->
        <!--                        <div class="col-xl-12 col-lg-12 col-md-12 form-group">-->
        <!--                            <label for="password_confirmation">Confirmed Password </label>-->
        <!--                            <input type="password" class="form-control password <?php echo e($errors->has('password_confirmation')?'error':''); ?>" name="password_confirmation" placeholder="Confirmed password" required="" />-->
        <!--                            <?php if($errors->has('password_confirmation')): ?>-->
        <!--                            <p style="color: red; margin: 0;"><?php echo e($errors->first('password_confirmation')); ?></p>-->
        <!--                            <?php endif; ?>-->
        <!--                        </div>-->
        <!--                        <div class="col-12">-->
        <!--                            <button type="submit" class="btn btn-danger">Change Password</button>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </form>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>



<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>



<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/resources/views/admin/users/suppliers/editUser.blade.php ENDPATH**/ ?>