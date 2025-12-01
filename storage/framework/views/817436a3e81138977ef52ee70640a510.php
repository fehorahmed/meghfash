  <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Register')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startSection('SEO'); ?>
<meta name="title" property="og:title" content="<?php echo e(general()->meta_title); ?>" />
<meta name="description" property="og:description" content="<?php echo general()->meta_description; ?>" />
<meta name="keyword" property="og:keyword" content="<?php echo e(general()->meta_keyword); ?>" />
<meta name="image" property="og:image" content="<?php echo e(asset(general()->logo())); ?>" />
<meta name="url" property="og:url" content="<?php echo e(route('register')); ?>" />
<link rel="canonical" href="<?php echo e(route('register')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>

<style>

.regisPage {
    padding: 50px 0;
    background-color: #f9f9f9;
}
a.regisLogin {
    display: block;
    text-align: center;
    font-size: 20px;
    color: darkred;
    margin-top: 15px;
    font-weight: bold;
    letter-spacing: 1px;
}
a.regisLogin span{
    color: blue;
}
.loginForm {
    padding: 22px 30px;
    background-color: #fff;
    border: 1px solid #a01a22;
}
.loginForm h4 {
    text-align: center;
    font-weight: bold;
    color: #c56d6d;
}
.loginForm .form-label {
    font-weight: 600;
    font-size: 14px;
    color: #726161;
    margin-bottom: 2px;
}
.loginForm .form-control {
    text-align: left;
    border-radius: 0;
    padding: 10px 20px;
    margin: 0;
}
.loginForm  .form-control:focus {
    border-color: #86b7fe;
    box-shadow: none;
}
.loginForm p {
    text-align: right;
}
.loginForm p a {
    color: #a01a22;
    display: block;
    text-align: center;
    margin-top: 20px;
    letter-spacing: 1px;
}
a.signBtn {
    display: block;
    background-color: #000;
    text-align: center;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-top: 20px;
    padding: 10px 0;
    transition-duration: 0.2s;
}
.loginForm button.btn-auth {
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
.loginForm button.btn-auth:hover {
    background-color: #7a1219;
}
</style>

<?php $__env->stopPush(); ?> 

<?php $__env->startSection('contents'); ?>

<div class="regisPage">
    <div class="container">
        <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-6">
                  <?php echo $__env->make(welcomeTheme().'.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <form class="loginForm" action="<?php echo e(route('register')); ?>" method="post">
                      <?php echo csrf_field(); ?>
                      <h5>Become User</h5>
                      <span>if your new to our store, we glad to have you as member.</span>
                      <div class="mb-3">
                          <label for="name" class="form-label">Name*</label>
                          <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" placeholder="Enter Your Name">
                          <?php if($errors->has('name')): ?>
                            <span style="color:red;display: block;"><?php echo e($errors->first('name')); ?></span>
                          <?php endif; ?>
                     </div>
                     <div class="mb-3">
                          <label for="email" class="form-label">Email*</label>
                          <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control" placeholder="Enter Your Email">
                          <?php if($errors->has('email')): ?>
                              <span style="color:red;display: block;"><?php echo e($errors->first('email')); ?></span>
                          <?php endif; ?>
                     </div>
                      <div class="mb-3">
                          <label for="exampleFormControlInput1" class="form-label">Password*</label>
                          <input type="password" name="password" class="form-control" placeholder="Enter Your Password">
                          <?php if($errors->has('password')): ?>
                            <span style="color:red;display: block;"><?php echo e($errors->first('password')); ?></span>
                          <?php endif; ?>
                     </div>
                     <button type="submit" class="btn-auth">Sign Up</button>
                 </form>
              </div>
              <div class="col-md-3"></div>
              <div class="col-md-12">
                <a class="regisLogin" href="<?php echo e(route('login')); ?>">Alrady Have An Account? <span>Log-In</span></a>
              </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>

<?php echo $__env->make(welcomeTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\posher-react-laravel\resources\views/auth/register.blade.php ENDPATH**/ ?>