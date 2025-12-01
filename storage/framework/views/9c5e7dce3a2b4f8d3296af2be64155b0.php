 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle(ucfirst($type).' Setting')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0"><?php echo e(ucfirst($type)); ?> Setting</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active"><?php echo e(ucfirst($type)); ?> Setting</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary reloadPage" href="javascript:void(0)">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


<?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<form action="<?php echo e(route('admin.settingUpdate','sms')); ?>" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="card">
        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
            <h4 class="card-title">SMS Setting</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                            <label for="sms_type">SMS Type</label>
                            <select name="sms_type" class="form-control <?php echo e($errors->has('sms_type')?'error':''); ?>">
                                <option value="Non-Masking" <?php echo e($general->sms_type=='Non Masking'?'selected':''); ?>>Non-Masking</option>
                                <option value="Masking" <?php echo e($general->sms_type=='Masking'?'selected':''); ?>>Masking</option>
                            </select>
                            <?php if($errors->has('sms_type')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('sms_type')); ?></p>
                            <?php endif; ?>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                        <label for="sms_senderid">SMS Sender ID</label>
                        <input type="text" name="sms_senderid" value="<?php echo e($general->sms_senderid); ?>" placeholder="SMS Sender ID" class="form-control <?php echo e($errors->has('sms_senderid')?'error':''); ?>" />
                        <?php if($errors->has('sms_senderid')): ?>
                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('sms_senderid')); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                        <label for="sms_url_nonmasking">SMS Url Non-Masking</label>
                        <input type="text" name="sms_url_nonmasking" value="<?php echo e($general->sms_url_nonmasking); ?>" placeholder="SMS Url Non-Masking" class="form-control <?php echo e($errors->has('sms_url_nonmasking')?'error':''); ?>" />
                        <?php if($errors->has('sms_url_nonmasking')): ?>
                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('sms_url_nonmasking')); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                        <label for="sms_url_masking">SMS Url Masking</label>
                        <input type="text" name="sms_url_masking" value="<?php echo e($general->sms_url_masking); ?>" placeholder="SMS Url Masking" class="form-control <?php echo e($errors->has('sms_url_masking')?'error':''); ?>" />
                        <?php if($errors->has('sms_url_masking')): ?>
                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('sms_url_masking')); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                        <label for="sms_username">SMS Username</label>
                        <input type="text" name="sms_username" value="<?php echo e($general->sms_username); ?>" placeholder="SMS Username  " class="form-control <?php echo e($errors->has('sms_username')?'error':''); ?>" />
                        <?php if($errors->has('sms_username')): ?>
                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('sms_username')); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                        <label for="sms_password">SMS Password</label>
                        <div class="input-group">
                            <input type="password" name="sms_password" value="<?php echo e($general->sms_password); ?>" placeholder="SMS Password" class="form-control password <?php echo e($errors->has('sms_password')?'error':''); ?>" />
                            <div class="input-group-append">
                                <span class="input-group-text showPassword"><i class="fa fa-eye-slash"></i></span>
                            </div>
                        </div>
                        <?php if($errors->has('sms_password')): ?>
                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('sms_password')); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 form-group">
                        <label for="admin_numbers">Author Mobile <small>(use comma, for multiple number)</small></label>
                        <input
                            type="text"
                            name="admin_numbers"
                            value="<?php echo e($general->admin_numbers); ?>"
                            placeholder="Author Mobile  (use comma, for multiple)"
                            class="form-control <?php echo e($errors->has('admin_numbers')?'error':''); ?>"
                        />
                        <?php if($errors->has('admin_numbers')): ?>
                        <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('admin_numbers')); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                        <label for="sms_status">SMS Status</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="sms_status" id="sms_status" <?php echo e($general->sms_status?'checked':''); ?>/>
                            <label class="custom-control-label" for="sms_status" style="cursor: pointer;">Active <small>(SMS System Active)</small></label>
                        </div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 mb-1">
                        <button type="submit" class="btn btn-primary btn-md rounded-0 mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/setting/sms.blade.php ENDPATH**/ ?>