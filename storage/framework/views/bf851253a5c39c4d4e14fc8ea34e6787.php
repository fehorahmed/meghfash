 
<?php $__env->startSection('title'); ?>
<title><?php echo e(websiteTitle('Page Edit')); ?></title>
<?php $__env->stopSection(); ?> 
<?php $__env->startPush('css'); ?>

<style type="text/css">

</style>
<?php $__env->stopPush(); ?> 
<?php $__env->startSection('contents'); ?>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0">Page Edit</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard </a></li>
                    <li class="breadcrumb-item active">Page Edit</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.pages')); ?>">BACK</a>
            <!--<a class="btn btn-outline-info MenuSetting" href="javascript:void(0)" data-id="<?php echo e($page->id); ?>">Add Menus</a>-->
            <?php if(isset(json_decode(Auth::user()->permission->permission, true)['pages']['add'])): ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.pagesAction','create')); ?>" onclick="return confirm('Are You Want To New page?')">Add Page</a>
            <?php endif; ?>
            <a class="btn btn-outline-primary" href="<?php echo e(route('admin.pagesAction',['edit',$page->id])); ?>">
                <i class="fa-solid fa-rotate"></i>
            </a>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Basic Elements start -->
    <section class="basic-elements">
    <?php echo $__env->make(adminTheme().'alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <form action="<?php echo e(route('admin.pagesAction',['update',$page->id])); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Page Edit 
                            	<?php if($page->slug): ?>
                            	<a href="<?php echo e(route('pageView',$page->slug)); ?>" class="badge badge-success float-right" target="_blank">View</a>
                            	<?php endif; ?>
                            </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Page Name 
                                        <?php if($page->template): ?>
                                    	<span style="color: #ccc;">(<?php echo e($page->template); ?>)</span>
                                    	<?php endif; ?>
                                    </label>
                                    <input type="text" class="form-control <?php echo e($errors->has('name')?'error':''); ?>" name="name" placeholder="Enter Page Name" value="<?php echo e($page->name?:old('name')); ?>" required="" />
                                    <?php if($errors->has('name')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('name')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="short_description">Short Description </label>
                                    <textarea name="short_description" class="form-control <?php echo e($errors->has('short_description')?'error':''); ?>" placeholder="Enter Short Description"><?php echo $page->short_description; ?></textarea>
                                    <?php if($errors->has('short_description')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('short_description')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description </label>
                                    <textarea name="description" class="<?php echo e($errors->has('description')?'error':''); ?> tinyEditor" placeholder="Enter Description"><?php echo $page->description; ?></textarea>
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
                                    <input type="text" class="form-control <?php echo e($errors->has('seo_title')?'error':''); ?>" name="seo_title" placeholder="Enter SEO Meta Title" value="<?php echo e($page->seo_title?:old('seo_title')); ?>" />
                                    <?php if($errors->has('seo_title')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('seo_title')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="seo_description">SEO Meta Description </label>
                                    <textarea name="seo_description" class="form-control <?php echo e($errors->has('seo_description')?'error':''); ?>" placeholder="Enter SEO Meta Description"><?php echo $page->seo_description; ?></textarea>
                                    <?php if($errors->has('seo_description')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('seo_description')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="seo_keyword">SEO Meta Keyword </label>
                                    <textarea name="seo_keyword" class="form-control <?php echo e($errors->has('seo_keyword')?'error':''); ?>" placeholder="Enter SEO Meta Keyword"><?php echo $page->seo_keyword; ?></textarea>
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
                            <h4 class="card-title">Page Images</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="image">Page Image</label>
                                    <input type="file" name="image" class="form-control <?php echo e($errors->has('image')?'error':''); ?>" />
                                    <?php if($errors->has('image')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('image')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <img src="<?php echo e(asset($page->image())); ?>" style="max-width: 100px;" />
                                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['pages']['add'])): ?>
                                    <?php if($page->imageFile): ?>
                                    <a href="<?php echo e(route('admin.mediesDelete',$page->imageFile->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="banner">Page Banner (1500X400)</label>
                                    <input type="file" name="banner" class="form-control <?php echo e($errors->has('banner')?'error':''); ?>" />
                                    <?php if($errors->has('banner')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('banner')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <img src="<?php echo e(asset($page->banner())); ?>" style="max-width: 200px;" />
                                    <?php if(isset(json_decode(Auth::user()->permission->permission, true)['pages']['add'])): ?>
                                    <?php if($page->bannerFile): ?>
                                    <a href="<?php echo e(route('admin.mediesDelete',$page->bannerFile->id)); ?>" class="mediaDelete" style="color: red;"><i class="fa fa-trash"></i></a>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Galleries</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <?php if($errors->has('galleries*')): ?>
                                <p style="color: red; margin: 0; font-size: 10px;">The Galleries Must Be a Number</p>
                                <?php endif; ?>
                                <select data-placeholder="Select Gallery..." name="galleries[]" class="select2 form-control" multiple="multiple">
                                    <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($gallery->id); ?>" <?php $__currentLoopData = $page->postTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $posttag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($posttag->reff_id==$gallery->id?'selected':''); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>><?php echo e($gallery->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                            <h4 class="card-title">Page Action</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="template">Page Template</label>
                                    <select class="form-control" name="template">
                                        <option value="">Default Template</option>
                                        <option value="Front Page" <?php echo e($page->template=='Front Page'?'selected':''); ?>>Front Page</option>
                                        <option value="Latest Blog" <?php echo e($page->template=='Latest Blog'?'selected':''); ?>>Latest Blog</option>
                                        <option value="Latest Products" <?php echo e($page->template=='Latest Products'?'selected':''); ?>>Latest Products</option>
                                        <option value="All Brands" <?php echo e($page->template=='All Brands'?'selected':''); ?>>All Brands</option>
                                        <option value="About Us" <?php echo e($page->template=='About Us'?'selected':''); ?>>About Us</option>
                                        <option value="Contact Us" <?php echo e($page->template=='Contact Us'?'selected':''); ?>>Contact Us</option>
                                    </select>
                                    <?php if($errors->has('template')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('template')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="status">Page Status</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" <?php echo e($page->status=='active'?'checked':''); ?>/>
                                            <label class="custom-control-label" for="status">Active</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="fetured">Page Featured</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="fetured" name="fetured" <?php echo e($page->fetured?'checked':''); ?>/>
                                            <label class="custom-control-label" for="fetured">Active</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Published Date</label>
                                    <input type="date" class="form-control form-control-sm" name="created_at" value="<?php echo e($page->created_at->format('Y-m-d')); ?>">
                                    <?php if($errors->has('created_at')): ?>
                                    <p style="color: red; margin: 0; font-size: 10px;"><?php echo e($errors->first('created_at')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php if(isset(json_decode(Auth::user()->permission->permission, true)['pages']['add'])): ?>
                                <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">Save changes</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        
        
        
    </section>
    <!-- Basic Inputs end -->
</div>

<?php $__env->stopSection(); ?> <?php $__env->startPush('js'); ?>



<?php $__env->stopPush(); ?>

<?php echo $__env->make(adminTheme().'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/admin/pages/pageEdit.blade.php ENDPATH**/ ?>