 <?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Clients Edit')); ?></title>
<?php $__env->stopSection(); ?> <?php $__env->startPush('css'); ?>


<style type="text/css"></style>
<?php $__env->stopPush(); ?> <?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Client Edit</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Client Edit</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.clients')); ?>">BACK</a>
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['clients']['add'])): ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.clientsAction',['create'])); ?>">Add Client</a>
            <?php endif; ?>
            <a class="btn btn-outline-primary reloadPage" href="javascript:void(0)">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>


<?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<form action="<?php echo e(route('admin.clientsAction',['update',$client->id])); ?>" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title">Client Edit</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Client Name(*) </label>
                            <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Client Name" value="<?php echo e($client->name?:old('name')); ?>" required="" />
                            <?php if($errors->has('name')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="short_description">Short Description </label>
                            <textarea name="short_description" class="form-control <?php echo e($errors->has('short_description')?'error':''); ?>" placeholder="Enter Short Description"><?php echo $client->short_description; ?></textarea>
                            <?php if($errors->has('short_description')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('short_description')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="description">Description </label>
                            <textarea name="description" class="<?php echo e($errors->has('description')?'error':''); ?> tinyEditor" placeholder="Enter Description"><?php echo $client->description; ?></textarea>
                            <?php if($errors->has('description')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('description')); ?></p>
                            <?php endif; ?>
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
                        <div class="form-group">
                            <label for="seo_title">SEO Meta Title</label>
                            <input type="text" class="form-control <?php echo e($errors->has('seo_title')?'error':''); ?>" name="seo_title" placeholder="Enter SEO Meta Title" value="<?php echo e($client->seo_title?:old('seo_title')); ?>" />
                            <?php if($errors->has('seo_title')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('seo_title')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="seo_description">SEO Meta Description </label>
                            <textarea name="seo_description" class="form-control <?php echo e($errors->has('seo_description')?'error':''); ?>" placeholder="Enter SEO Meta Description"><?php echo $client->seo_description; ?></textarea>
                            <?php if($errors->has('seo_description')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('seo_description')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="seo_keyword">SEO Meta Keyword </label>
                            <textarea name="seo_keyword" class="form-control <?php echo e($errors->has('seo_keyword')?'error':''); ?>" placeholder="Enter SEO Meta Keyword"><?php echo $client->seo_keyword; ?></textarea>
                            <?php if($errors->has('seo_keyword')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('seo_keyword')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title">Client Images</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="image">Client Image</label>
                            <input type="file" name="image" class="form-control <?php echo e($errors->has('image')?'error':''); ?>" />
                            <?php if($errors->has('image')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <img src="<?php echo e(asset($client->image())); ?>" style="max-width: 100px;" />
                            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['clients']['add'])): ?>
                            <?php if($client->imageFile): ?>
                            <a href="<?php echo e(route('admin.mediesDelete',$client->imageFile->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="banner">Client Banner</label>
                            <input type="file" name="banner" class="form-control <?php echo e($errors->has('banner')?'error':''); ?>" />
                            <?php if($errors->has('banner')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('banner')); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <img src="<?php echo e(asset($client->banner())); ?>" style="max-width: 200px;" />
                            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['clients']['add'])): ?>
                            <?php if($client->bannerFile): ?>
                            <a href="<?php echo e(route('admin.mediesDelete',$client->bannerFile->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title">Client Action</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="status">Client Status</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="status" name="status" <?php echo e($client->status=='active'?'checked':''); ?>/>
                                    <label class="custom-control-label" for="status">Active</label>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label for="fetured">Client Featured</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="fetured" name="fetured" <?php echo e($client->fetured?'checked':''); ?>/>
                                    <label class="custom-control-label" for="fetured">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Published Date</label>
                            <input type="date" class="form-control form-control-sm" name="created_at" value="<?php echo e($client->created_at->format('Y-m-d')); ?>">
                            <?php if($errors->has('created_at')): ?>
                            <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('created_at')); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php if(isset(json_decode(Auth::user()->permission->permission, true)['clients']['add'])): ?>
                        <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?>


<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/posherbd/public_html/resources/views/admin/clients/clientsEdit.blade.php ENDPATH**/ ?>