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
<form action="<?php echo e(route('admin.settingUpdate',$type)); ?>" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Social link</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="facebook_link">Facebook Link </label>
                    <input type="text" name="facebook_link" value="<?php echo e($general->facebook_link); ?>" placeholder="Facebook Link" class="form-control <?php echo e($errors->has('facebook_link')?'error':''); ?>" />
                    <?php if($errors->has('facebook_link')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('facebook_link')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="twitter_link">Twitter Link</label>
                    <input type="text" name="twitter_link" value="<?php echo e($general->twitter_link); ?>" placeholder="Twitter Link" class="form-control <?php echo e($errors->has('twitter_link')?'error':''); ?>" />
                    <?php if($errors->has('twitter_link')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('twitter_link')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="instagram_link">Instagram Link</label>
                    <input type="text" name="instagram_link" value="<?php echo e($general->instagram_link); ?>" placeholder="Instagram Link" class="form-control <?php echo e($errors->has('instagram_link')?'error':''); ?>" />
                    <?php if($errors->has('instagram_link')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('instagram_link')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="linkedin_link">Linkedin Link</label>
                    <input type="text" name="linkedin_link" value="<?php echo e($general->linkedin_link); ?>" placeholder="Linkedin Link" class="form-control <?php echo e($errors->has('linkedin_link')?'error':''); ?>" />
                    <?php if($errors->has('linkedin_link')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('linkedin_link')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="youtube_link">Youtube Link</label>
                    <input type="text" name="youtube_link" value="<?php echo e($general->youtube_link); ?>" placeholder="Youtube Link" class="form-control <?php echo e($errors->has('youtube_link')?'error':''); ?>" />
                    <?php if($errors->has('youtube_link')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('youtube_link')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="pinterest_link">Pinterest Link</label>
                    <input type="text" name="pinterest_link" value="<?php echo e($general->pinterest_link); ?>" placeholder="Pinterest Link" class="form-control <?php echo e($errors->has('pinterest_link')?'error':''); ?>" />
                    <?php if($errors->has('pinterest_link')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('pinterest_link')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">Social Ingreation</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-12 form-group">
                    <label for="fb_app_id">Facebook App ID </label>
                    <input type="text" name="fb_app_id" value="<?php echo e($general->fb_app_id); ?>" placeholder="Facebook App ID" class="form-control <?php echo e($errors->has('fb_app_id')?'error':''); ?>" />
                    <?php if($errors->has('fb_app_id')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('fb_app_id')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 form-group">
                    <label for="fb_app_secret">Facebook App Secret</label>
                    <input type="text" name="fb_app_secret" value="<?php echo e($general->fb_app_secret); ?>" placeholder="Facebook App Secret" class="form-control <?php echo e($errors->has('fb_app_secret')?'error':''); ?>" />
                    <?php if($errors->has('fb_app_secret')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('fb_app_secret')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 form-group">
                    <label for="fb_app_redirect_url">Facebook Redirect Url</label>
                    <input
                        type="text"
                        name="fb_app_redirect_url"
                        value="<?php echo e($general->fb_app_redirect_url); ?>"
                        placeholder="Facebook Redirect Url"
                        class="form-control <?php echo e($errors->has('fb_app_redirect_url')?'error':''); ?>"
                    />
                    <?php if($errors->has('fb_app_redirect_url')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('fb_app_redirect_url')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 form-group">
                    <label for="google_client_id">Google App ID </label>
                    <input type="text" name="google_client_id" value="<?php echo e($general->google_client_id); ?>" placeholder="Google App ID" class="form-control <?php echo e($errors->has('google_client_id')?'error':''); ?>" />
                    <?php if($errors->has('google_client_id')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('google_client_id')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 form-group">
                    <label for="google_client_secret">Google App Secret</label>
                    <input
                        type="text"
                        name="google_client_secret"
                        value="<?php echo e($general->google_client_secret); ?>"
                        placeholder="Google App Secret"
                        class="form-control <?php echo e($errors->has('google_client_secret')?'error':''); ?>"
                    />
                    <?php if($errors->has('google_client_secret')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('google_client_secret')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 form-group">
                    <label for="google_client_redirect_url">Google Redirect Url</label>
                    <input
                        type="text"
                        name="google_client_redirect_url"
                        value="<?php echo e($general->google_client_redirect_url); ?>"
                        placeholder="Google Redirect Url"
                        class="form-control <?php echo e($errors->has('google_client_redirect_url')?'error':''); ?>"
                    />
                    <?php if($errors->has('google_client_redirect_url')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('google_client_redirect_url')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 form-group">
                    <label for="tw_app_id">Twitter App ID </label>
                    <input type="text" name="tw_app_id" value="<?php echo e($general->tw_app_id); ?>" placeholder="Twitter App ID" class="form-control <?php echo e($errors->has('tw_app_id')?'error':''); ?>" />
                    <?php if($errors->has('tw_app_id')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('tw_app_id')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 form-group">
                    <label for="tw_app_secret">Twitter App Secret</label>
                    <input type="text" name="tw_app_secret" value="<?php echo e($general->tw_app_secret); ?>" placeholder="Twitter App Secret" class="form-control <?php echo e($errors->has('tw_app_secret')?'error':''); ?>" />
                    <?php if($errors->has('tw_app_secret')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('tw_app_secret')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-12 form-group">
                    <label for="tw_app_redirect_url">Twitter Redirect Url</label>
                    <input
                        type="text"
                        name="tw_app_redirect_url"
                        value="<?php echo e($general->tw_app_redirect_url); ?>"
                        placeholder="Twitter Redirect Url"
                        class="form-control <?php echo e($errors->has('tw_app_redirect_url')?'error':''); ?>"
                    />
                    <?php if($errors->has('tw_app_redirect_url')): ?>
                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('tw_app_redirect_url')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>


<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?> <?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/public_html/resources/views/admin/setting/social.blade.php ENDPATH**/ ?>