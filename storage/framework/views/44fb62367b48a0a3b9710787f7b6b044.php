  <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Forget Password')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startSection('SEO'); ?>
<meta name="title" property="og:title" content="<?php echo e(general()->meta_title); ?>" />
<meta name="description" property="og:description" content="<?php echo general()->meta_description; ?>" />
<meta name="keyword" property="og:keyword" content="<?php echo e(general()->meta_keyword); ?>" />
<meta name="image" property="og:image" content="<?php echo e(asset(general()->logo())); ?>" />
<meta name="url" property="og:url" content="<?php echo e(route('forgotPassword')); ?>" />
<link rel="canonical" href="<?php echo e(route('forgotPassword')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>

<style>

    .lostpass{
        padding: 50px 0;
        background-color: #f9f9f9;
    }
    
    .forgetPassPage{
        padding:30px;
        background-color: #fff;
        border: 1px solid darkred;
    }
    
    .forgetPassPage p {
        font-size: 15px;
        margin-bottom: 20px;
    }
    
    .forgetPassPage .form-control {
        text-align: left;
        border-radius: 0;
        padding: 10px 20px;
        margin: 0;
    }
    .forgetPassPage  .form-control:focus {
        border-color: #86b7fe;
        box-shadow: none;
    }
    
    .forgetPassPage button.btn.submitbutton {
        background-color: #a01a22;
        color: #fff;
        font-size: 16px;
        display: block;
        text-transform: uppercase;
        border: none;
        padding: 10px 0;
        display: block;
        width: 100%;
        margin-top: 15px;
        transition: .2s all;
        letter-spacing: 1px;
    }
    
    .forgetPassPage label {
        display: block;
        margin-bottom: 5px;
    }
    
</style>

<?php $__env->stopPush(); ?> 

<?php $__env->startSection('contents'); ?>

<div class="lostpass">
	<div class="container">
	    <div class="row">
		    <div class="col-md-3"></div>
		    <div class="col-md-6">
		        <div class="forgetPassPage">
		            <p>
            			Lost your password? Please enter your email address. You will receive a link to create a new password via email.
            		</p>
            
            		<form  method="POST" action="<?php echo e(route('forgotPassword')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo $__env->make(welcomeTheme().'.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            			<label for="email">
            				 Email*
            			</label>
            			<div class="form-group form-group-section">
            			    <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control control-section" placeholder="Enter Your Email" required="">
            			    <?php if($errors->has('email')): ?>
                                <span style="color:red;display: block;"><?php echo e($errors->first('email')); ?></span>
                            <?php endif; ?>
            			</div>
            			<div>
            				<button type="submit" class="btn submitbutton">RESET PASSWORD</button>
            			</div>
            		</form>
            	</div>
		    </div>
		    <div class="col-md-3"></div>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>
<?php echo $__env->make(welcomeTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\posher-react-laravel\resources\views/auth/forget-password.blade.php ENDPATH**/ ?>