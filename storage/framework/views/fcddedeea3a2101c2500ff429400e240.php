 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle(ucfirst($type).' Setting')); ?></title>
<?php $__env->stopSection(); ?> 
<?php $__env->startPush('css'); ?>
<style type="text/css"></style>
<?php $__env->stopPush(); ?> 
<?php $__env->startSection('contents'); ?>

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
        <h4 class="card-title">General Info</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="title">Website Title </label>
                    <input type="text" name="title" value="<?php echo e($general->title); ?>" placeholder="Website Title" class="form-control <?php echo e($errors->has('title')?'error':''); ?>" />
                    <?php if($errors->has('title')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('title')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="subtitle">Website Subtitle</label>
                    <input type="text" name="subtitle" value="<?php echo e($general->subtitle); ?>" placeholder="Website subtitle" class="form-control <?php echo e($errors->has('subtitle')?'error':''); ?>" />
                    <?php if($errors->has('subtitle')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('subtitle')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="text" name="mobile" value="<?php echo e($general->mobile); ?>" placeholder="Website mobile" class="form-control <?php echo e($errors->has('mobile')?'error':''); ?>" />
                    <?php if($errors->has('mobile')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('mobile')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="email">Email Address</label>
                    <input type="text" name="email" value="<?php echo e($general->email); ?>" placeholder="Website email" class="form-control <?php echo e($errors->has('email')?'error':''); ?>" />
                    <?php if($errors->has('email')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('email')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 ">
                    <label for="address_one">Address line 1</label>
                    <textarea name="address_one" placeholder="Address Line 1" class="form-control  <?php echo e($errors->has('address_one')?'error':''); ?>"><?php echo e($general->address_one); ?></textarea>
                    <?php if($errors->has('address_one')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('address_one')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="address_two">Address line 2</label>
                    <textarea name="address_two" placeholder="Address Line 1" class="form-control <?php echo e($errors->has('address_two')?'error':''); ?>"><?php echo e($general->address_two); ?></textarea>
                    <?php if($errors->has('address_two')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('address_two')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="favicon">Favicon</label>
                    <input type="file" name="favicon" class="form-control <?php echo e($errors->has('favicon')?'error':''); ?>" />
                    <?php if($errors->has('favicon')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('favicon')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <img src="<?php echo e(asset($general->favicon())); ?>" style="max-width: 60px;" />
                    <?php if($general->favicon): ?>
                    <a href="<?php echo e(route('admin.setting','favicon')); ?>" style="color: red;" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                    <?php endif; ?>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="helpInputTop">Logo</label>
                    <input type="file" name="logo" class="form-control <?php echo e($errors->has('logo')?'error':''); ?>" />
                    <?php if($errors->has('logo')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('logo')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <img src="<?php echo e(asset($general->logo())); ?>" style="max-width: 150px;" />
                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['appsSetting']['general'])): ?> <?php if($general->logo): ?>
                    <a href="<?php echo e(route('admin.setting','logo')); ?>" style="color: red;" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                    <?php endif; ?> <?php endif; ?>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="helpInputTop">Banner</label>
                    <input type="file" name="banner" class="form-control <?php echo e($errors->has('banner')?'error':''); ?>" />
                    <?php if($errors->has('banner')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('banner')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <img src="<?php echo e(asset($general->banner())); ?>" style="max-width: 150px;" />
                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['appsSetting']['general'])): ?> <?php if($general->banner): ?>
                    <a href="<?php echo e(route('admin.setting','banner')); ?>" style="color: red;" onclick="return confirm('Are You Want To Delete?')"><i class="fa fa-trash"></i></a>
                    <?php endif; ?> <?php endif; ?>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="website">Website Url</label>
                    <input type="text" name="website" value="<?php echo e($general->website); ?>" placeholder="Website website" class="form-control <?php echo e($errors->has('website')?'error':''); ?>" />
                    <?php if($errors->has('website')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('website')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 form-group">
                    <label for="footer_text">Footer Text</label>
                    <input type="text" name="footer_text" value="<?php echo e($general->copyright_text); ?>" placeholder="Website Footer Text" class="form-control <?php echo e($errors->has('footer_text')?'error':''); ?>" />
                    <?php if($errors->has('footer_text')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('footer_text')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
        <h4 class="card-title">SEO Optimize</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="meta_author">Meta Author</label>
                    <input type="text" name="meta_author" value="<?php echo e($general->meta_author); ?>" placeholder="Meta Author" class="form-control <?php echo e($errors->has('meta_author')?'error':''); ?>" />
                    <?php if($errors->has('meta_author')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('meta_author')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="meta_title">Meta title <small>(Max: 60 L)</small></label>
                    <input type="text" name="meta_title" value="<?php echo e($general->meta_title); ?>" placeholder="Meta title" class="form-control <?php echo e($errors->has('meta_title')?'error':''); ?>" />
                    <?php if($errors->has('meta_title')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('meta_title')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="meta_keyword">Meta keyword </label>
                    <textarea name="meta_keyword" placeholder="Meta keyword" class="form-control  <?php echo e($errors->has('meta_keyword')?'error':''); ?>"><?php echo e($general->meta_keyword); ?></textarea>
                    <?php if($errors->has('meta_keyword')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('meta_keyword')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="meta_description">Meta Description <small>(Max: 160 L)</small></label>
                        <textarea name="meta_description" placeholder="Meta Description" class="form-control  <?php echo e($errors->has('meta_description')?'error':''); ?>"><?php echo e($general->meta_description); ?></textarea>
                        <?php if($errors->has('meta_description')): ?>
                        <p style="color: red; margin: 0;"><?php echo e($errors->first('meta_description')); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="script_head">Script tag Head</label>
                        <textarea name="script_head" placeholder="Script tag Head" class="form-control  <?php echo e($errors->has('script_head')?'error':''); ?>"><?php echo e($general->script_head); ?></textarea>
                        <?php if($errors->has('script_head')): ?>
                        <p style="color: red; margin: 0;"><?php echo e($errors->first('script_head')); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="script_body">Script tag Body</label>
                    <textarea name="script_body" placeholder="Script tag Body" class="form-control  <?php echo e($errors->has('script_body')?'error':''); ?>"><?php echo e($general->script_body); ?></textarea>
                    <?php if($errors->has('script_body')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('script_body')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="custom_css">Style CSS</label>
                    <textarea name="custom_css" placeholder="Custom Css write here..." class="form-control  <?php echo e($errors->has('custom_css')?'error':''); ?>"><?php echo e($general->custom_css); ?></textarea>
                    <?php if($errors->has('custom_css')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('custom_css')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 form-group">
                    <label for="custom_js">Script js</label>
                    <textarea name="custom_js" placeholder="Custom Script js write here..." class="form-control  <?php echo e($errors->has('custom_js')?'error':''); ?>"><?php echo e($general->custom_js); ?></textarea>
                    <?php if($errors->has('custom_js')): ?>
                    <p style="color: red; margin: 0;"><?php echo e($errors->first('custom_js')); ?></p>
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

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\poshak\resources\views/admin/setting/general.blade.php ENDPATH**/ ?>