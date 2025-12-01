 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('My Profile')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>

<style type="text/css">
    .ProfileImage {
        max-width: 64px;
        max-height: 64px;
    }
</style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-body">
    <div id="user-profile">
        <?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">My Profile</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.myProfile')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" value="profile" name="actionType">
                                <div class="media">
                                    <a href="javascript: void(0);">
                                        <img src="<?php echo e(route('imageView2',['profile',$user->imageName(),'w'=>100,'h'=>100])); ?>" class="ProfileImage image_<?php echo e($user->id); ?>" alt="profile image" />
                                    </a>
                                    <div class="media-body mt-75">
                                        <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                            <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer" for="account-upload">Upload new photo </label>
                                            <input type="file" name="image" class="profile-upload" id="account-upload" data-imageshow="image_<?php echo e($user->id); ?>" hidden="" />
                                            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['users']['update'])): ?> <?php if($user->imageFile): ?>
                                            <a href="<?php echo e(route('admin.mediesDelete',$user->imageFile->id)); ?>" class="mediaDelete btn btn-sm btn-secondary ml-50">Reset </a>
                                            <?php endif; ?> <?php endif; ?>
                                        </div>
                                        <?php if($errors->has('image')): ?>
                                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image')); ?></p>
                                        <?php endif; ?>
                                        <p class="text-muted ml-75 mt-50"><small>Allowed JPG, GIF or PNG. Max size of 2048kB</small></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="name">Name* </label>
                                                <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Name" value="<?php echo e($user->name?:old('name')); ?>" required="" />
                                                <?php if($errors->has('name')): ?>
                                                <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="email">Email* </label>
                                                <input type="email" class="form-control <?php echo e($errors->has('email')?'error':''); ?>" name="email" placeholder="Enter Email" value="<?php echo e($user->email?:old('email')); ?>" required="" />
                                                <?php if($errors->has('email')): ?>
                                                <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('email')); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="mobile">Mobile* </label>
                                                <input type="text" class="form-control <?php echo e($errors->has('mobile')?'error':''); ?>" name="mobile" placeholder="Enter Mobile" value="<?php echo e($user->mobile?:old('mobile')); ?>" />
                                                <?php if($errors->has('mobile')): ?>
                                                <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('mobile')); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label for="gender">Gender </label>
                                            <select class="form-control <?php echo e($errors->has('gender')?'error':''); ?>" name="gender">
                                                <option value="">Select Gender</option>
                                                <option value="Male" <?php echo e($user->gender=='Male'?'selected':''); ?>>Male</option>
                                                <option value="Female" <?php echo e($user->gender=='Female'?'selected':''); ?>>Female</option>
                                            </select>
                                            <?php if($errors->has('gender')): ?>
                                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('gender')); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label for="division">Division </label>
                                            <select id="division" class="form-control <?php echo e($errors->has('division')?'error':''); ?>" name="division">
                                                <option value="">Select Division</option>

                                                <?php $__currentLoopData = App\Models\Country::where('type',2)->where('parent_id',1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($data->id); ?>" <?php echo e($data->id==$user->division?'selected':''); ?>><?php echo e($data->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label for="district">District </label>
                                            <select id="district" class="form-control <?php echo e($errors->has('district')?'error':''); ?>" name="district">
                                                <?php if($user->division==null): ?>
                                                <option value="">No District</option>
                                                <?php else: ?>
                                                <option value="">Select District</option>
                                                <?php $__currentLoopData = App\Models\Country::where('type',3)->where('parent_id',$user->division)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($data->id); ?>" <?php echo e($data->id==$user->district?'selected':''); ?>><?php echo e($data->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label for="city">City </label>
                                            <select id="city" class="form-control <?php echo e($errors->has('city')?'error':''); ?>" name="city">
                                                <?php if($user->district==null): ?>
                                                <option value="">No City</option>
                                                <?php else: ?>
                                                <option value="">Select City</option>
                                                <?php $__currentLoopData = App\Models\Country::where('type',4)->where('parent_id',$user->district)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($data->id); ?>" <?php echo e($data->id==$user->city?'selected':''); ?>><?php echo e($data->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="postal_code">Postal Code</label>
                                                <input type="text" class="form-control <?php echo e($errors->has('postal_code')?'error':''); ?>" name="postal_code" placeholder="Enter Postal Code" value="<?php echo e($user->postal_code?:old('postal_code')); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="address">Address Line</label>
                                                <input type="text" class="form-control <?php echo e($errors->has('address')?'error':''); ?>" name="address" placeholder="Enter Address" value="<?php echo e($user->address_line1?:old('address')); ?>" />
                                            </div>
                                        </div>
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
                <div class="card">
                    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                        <h4 class="card-title">Change Password</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.myProfile')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" value="change-password" name="actionType">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="old_password">Old password </label>
                                            <div class="input-group">
                                                <input type="password" class="form-control password" placeholder="Old Password" name="old_password" value="<?php echo e(old('old_password')); ?>" required="" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text showPassword"><i class="fa fa-eye-slash"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="password">New Password </label>
                                            <input type="password" class="form-control password <?php echo e($errors->has('password')?'error':''); ?>" name="password" placeholder="New password" required="" />
                                            <?php if($errors->has('password')): ?>
                                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('password')); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirmed Password </label>
                                            <input type="password" class="form-control password <?php echo e($errors->has('password_confirmation')?'error':''); ?>" name="password_confirmation" placeholder="Confirmed password" required="" />
                                            <?php if($errors->has('password_confirmation')): ?>
                                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('password_confirmation')); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-danger">Change Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?> 

<?php $__env->startPush('js'); ?> 

<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/users/myProfile.blade.php ENDPATH**/ ?>