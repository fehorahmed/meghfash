
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Customer Profile')); ?></title>
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
     <h3 class="content-header-title mb-0">Customer Profile</h3>
     <div class="row breadcrumbs-top">
       <div class="breadcrumb-wrapper col-12">
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a>
           </li>
           <li class="breadcrumb-item active">Customer Profile</li>
         </ol>
       </div>
     </div>
    </div>
   <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
     <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
       
       <a class="btn btn-outline-primary" href="<?php echo e(route('admin.usersWholesaleCustomer')); ?>">
       		Back
       	</a>
       	<a class="btn btn-outline-primary reloadPage" href="javascript:void(0)">
       		<i class="fa-solid fa-rotate"></i>
       	</a>
     </div>
   </div>
</div>
 
	

    <?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title">Customer Profile</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.usersWholesaleCustomerAction',['update',$user->id])); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="media">
                                <a href="javascript: void(0);">
                                    <img src="<?php echo e(asset($user->image())); ?>" class="ProfileImage image_<?php echo e($user->id); ?>" alt="profile image" />
                                </a>
                                <div class="media-body mt-75">
                                    <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                        <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer" for="account-upload">Upload new photo </label>
                                        <input type="file" name="image" id="account-upload" class="profile-upload" data-imageshow="image_<?php echo e($user->id); ?>" hidden="" />
                                        <?php if(isset(json_decode(Auth::user()->permission->permission, true)['users']['update'])): ?> <?php if($user->imageFile): ?>
                                        <a href="<?php echo e(route('admin.mediesDelete',$user->imageFile->id)); ?>" class="mediaDelete btn btn-sm btn-secondary ml-50">Reset </a>
                                        <?php endif; ?> <?php endif; ?>
                                    </div>
                                    <?php if($errors->has('image')): ?>
                                    <p style="color: red; margin: 0;"><?php echo e($errors->first('image')); ?></p>
                                    <?php endif; ?>
                                    <p class="text-muted ml-75 mt-50"><small>Allowed JPG, GIF or PNG. Max size of 2048kB</small></p>
                                </div>
                            </div>

                            <div class="row">
                                
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    <label for="company_name">Company Name* </label>
                                    <input type="text" class="form-control <?php echo e($errors->has('company_name')?'error':''); ?>" name="company_name" placeholder="Enter Company name" value="<?php echo e($user->company_name?:old('company_name')); ?>" required="" />
                                    <?php if($errors->has('company_name')): ?>
                                    <p style="color: red; margin: 0;"><?php echo e($errors->first('company_name')); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    <label for="name">Customer Name* </label>
                                    <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter customer Name" value="<?php echo e($user->name?:old('name')); ?>" required="" />
                                    <?php if($errors->has('name')): ?>
                                    <p style="color: red; margin: 0;"><?php echo e($errors->first('name')); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    <label for="mobile">Mobile* </label>
                                    <input type="text" class="form-control <?php echo e($errors->has('mobile')?'error':''); ?>" name="mobile" placeholder="Enter Mobile" value="<?php echo e($user->mobile?:old('mobile')); ?>" required=""  />
                                    <?php if($errors->has('mobile')): ?>
                                    <p style="color: red; margin: 0;"><?php echo e($errors->first('mobile')); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    <label for="email">Email </label>
                                    <input type="email" class="form-control <?php echo e($errors->has('email')?'error':''); ?>" name="email" placeholder="Enter Email" value="<?php echo e($user->email?:old('email')); ?>" />
                                    <?php if($errors->has('email')): ?>
                                    <p style="color: red; margin: 0;"><?php echo e($errors->first('email')); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                
                                <div class="col-xl-12 col-lg-12 col-md-12 form-group">
                                    <label for="address">Address Line</label>
                                    <input type="text" class="form-control <?php echo e($errors->has('address')?'error':''); ?>" name="address" placeholder="Enter Address" value="<?php echo e($user->address_line1?:old('address')); ?>" />
                                    <?php if($errors->has('address')): ?>
                                    <p style="color: red; margin: 0;"><?php echo e($errors->first('address')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    <label for="status">User Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="status" id="status" <?php echo e($user->status?'checked':''); ?>/>
                                        <label class="custom-control-label" for="status">User Active</label>
                                    </div>
                                    <?php if($errors->has('status')): ?>
                                    <p style="color: red; margin: 0;"><?php echo e($errors->first('status')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                                    <label for="created_at">Join Date</label>
                                    <input type="date" class="form-control <?php echo e($errors->has('created_at')?'error':''); ?>" name="created_at"  value="<?php echo e($user->created_at->format('Y-m-d')); ?>" />
                                    <?php if($errors->has('created_at')): ?>
                                    <p style="color: red; margin: 0;"><?php echo e($errors->first('created_at')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <!--<div class="card">-->
            <!--    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">-->
            <!--        <h4 class="card-title">Change Password</h4>-->
            <!--    </div>-->
            <!--    <div class="card-content">-->
            <!--        <div class="card-body">-->
            <!--            <form action="<?php echo e(route('admin.usersCustomerAction',['change-password',$user->id])); ?>" method="post">-->
            <!--                <?php echo csrf_field(); ?>-->
            <!--                <div class="row">-->
            <!--                    <div class="col-xl-12 col-lg-12 col-md-12 form-group">-->
            <!--                        <label for="old_password">Old password </label>-->
            <!--                        <div class="input-group">-->
            <!--                            <input type="password" class="form-control password" placeholder="Old Password" name="old_password" value="<?php echo e($user->password_show?:old('old_password')); ?>" required="" />-->
            <!--                            <div class="input-group-append">-->
            <!--                                <span class="input-group-text showPassword"><i class="fa fa-eye-slash"></i></span>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <?php if($errors->has('old_password')): ?>-->
            <!--                        <p style="color: red; margin: 0;"><?php echo e($errors->first('old_password')); ?></p>-->
            <!--                        <?php endif; ?>-->
            <!--                    </div>-->
            <!--                    <div class="col-xl-12 col-lg-12 col-md-12 form-group">-->
            <!--                        <label for="password">New Password </label>-->
            <!--                        <input type="password" class="form-control password <?php echo e($errors->has('password')?'error':''); ?>" name="password" placeholder="New password" required="" />-->
            <!--                        <?php if($errors->has('password')): ?>-->
            <!--                        <p style="color: red; margin: 0;"><?php echo e($errors->first('password')); ?></p>-->
            <!--                        <?php endif; ?>-->
            <!--                    </div>-->
            <!--                    <div class="col-xl-12 col-lg-12 col-md-12 form-group">-->
            <!--                        <label for="password_confirmation">Confirmed Password </label>-->
            <!--                        <input type="password" class="form-control password <?php echo e($errors->has('password_confirmation')?'error':''); ?>" name="password_confirmation" placeholder="Confirmed password" required="" />-->
            <!--                        <?php if($errors->has('password_confirmation')): ?>-->
            <!--                        <p style="color: red; margin: 0;"><?php echo e($errors->first('password_confirmation')); ?></p>-->
            <!--                        <?php endif; ?>-->
            <!--                    </div>-->
            <!--                    <div class="col-12">-->
            <!--                        <button type="submit" class="btn btn-danger">Change Password</button>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </form>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
        </div>
    </div>



<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>



<?php $__env->stopPush(); ?>
<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/users/wholesale-customers/editUser.blade.php ENDPATH**/ ?>